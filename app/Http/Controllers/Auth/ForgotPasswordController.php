<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    const VIEW_DIR = 'auth.';

    /**
     * Forgot Password page
     *
     * @return View
     */
    public function show(): View
    {
        return view(self::VIEW_DIR . 'forgotpassword');
    }


    /**
     * Send reset password link
     *
     * @param ForgotPasswordRequest $request
     * @return RedirectResponse
     */
    public function sendResetPassword(ForgotPasswordRequest $request): RedirectResponse
    {
        // get user by email
        $user = User::where('email', $request->email)->first();

        // check if not locked
        if (! is_null($user)
            && $user->is_lock_out
        ) {

            // return locked account
            return redirect()
                    ->back()
                    ->withErrors([message('account_locked')]);
        }

        // send reset password link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // prepare message
        $message = message($status);

        // if success
        if ($status === Password::RESET_LINK_SENT) {

            // let's make sure that user is logged out
            Session::flush();
            Auth::logout();

            return redirect()
                    ->back()
                    ->with('formMsg', $message);
        }

        return redirect()
                ->back()
                ->withErrors([$message]);

    }


    /**
     * Set New Password page
     *
     * @param string $token
     * @param Request $request
     * @return mixed
     */
    public function resetPassword($token, Request $request)
    {
        // get email
        $email = $request->email;

        // validate request has email
        if (! $email) {

            // abort
            abort(419, message('page_expired'));
        }

        // get user by email
        $user = Password::getUser(['email' => urldecode($email)]);

        // verify if token exists
        if (! Password::tokenExists($user, $token)) {
            abort(419, message('page_expired'));
        }

        return view(self::VIEW_DIR . 'reset_password', compact(
                                                        'token',
                                                        'email'
                                                    )
                                                );
    }


    /**
     * Update Password
     *
     * @param ResetPasswordRequest $request
     * @return RedirectResponse
     */
    public function update(ResetPasswordRequest $request): RedirectResponse
    {
        // reCaptcha validation
        $recaptcha_validation = self::recaptchaValidation($request);
        // check validation
        if ($recaptcha_validation instanceof \Illuminate\Http\RedirectResponse) {
            return $recaptcha_validation;
        }

        // reset password
        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {
                $user->update(['password' => $password]);
            }
        );

        // prepare message
        $message = message($status);

        // if success
        if ($status === Password::PASSWORD_RESET) {

            // let's make sure that user is logged out
            Session::flush();
            Auth::logout();

            return redirect()
                    ->route('login.show')
                    ->with('formMsg', $message);
        }

        return redirect()
                ->back()
                ->withErrors([$message]);
    }


    /**
     * reCaptcha validation
     *
     * @param Request $request
     * @return mixed
     */
    private function recaptchaValidation(Request $request)
    {
        // process reCaptcha
        try {
            // validate recaptcha
            $response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . env('RECAPTCHA_SECRET_KEY') . '&response=' . $request->input('g-recaptcha-response')));

            // invalid recaptcha
            $invalid_recaptcha = false;
            $invalid_recaptcha_message = message('invalid_recaptcha');


            // if null response or invalid response
            if (is_null($response)
                || !property_exists($response, 'success')
            ) {
                $invalid_recaptcha = true;
            }

            // if not success
            if (!$response->success) {
                $invalid_recaptcha = true;
            }

            // if reCaptcha has error or invalid
            if ($invalid_recaptcha) {
                return redirect()
                        ->back()
                        ->withErrors([$invalid_recaptcha_message]);
            }
        } catch (\Exception $e) {

            // log error
            Log::error('reCaptcha exception error', [
                'Line'      => $e->getLine(),
                'File'      => $e->getFile(),
                'Message'   => $e->getMessage()
            ]);

            return redirect()
                    ->back()
                    ->withErrors([$invalid_recaptcha_message]);
        }

        return true;
    }
}
