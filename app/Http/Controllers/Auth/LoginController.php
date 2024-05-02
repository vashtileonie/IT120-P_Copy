<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ConfigTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Session;

use App\Traits\GeneralTrait;


class LoginController extends Controller
{
    
    use ConfigTrait, GeneralTrait;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function show()
    {
        Session::put('topbar', 'Login');
        return view('auth.login');
    }


    public function login(LoginRequest $request): RedirectResponse
    {
        Session::put('topbar', 'Login');
        
        $credentials = $request->getCredentials();

        // if invalid credentials
        if (! Auth::validate($credentials)){
            return redirect()->to('/')->withErrors(trans('auth.failed'));
        }

        // retrieve user by creds
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        
        // login user
        Auth::login($user);

        // redirect to intended page
        return $this->authenticated($request, $user);
    }

  
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        //logout of other devices
        Auth::logoutOtherDevices($request->password);

        //redirect
        return redirect()->intended();
    }
}
