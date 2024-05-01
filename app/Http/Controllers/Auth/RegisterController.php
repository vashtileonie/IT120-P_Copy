<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\RegisterRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) 
    {
        $user = User::create($request->validated());
        auth()->login($user);
        return redirect('/')->with('success', "Account successfully registered.");
    }
}