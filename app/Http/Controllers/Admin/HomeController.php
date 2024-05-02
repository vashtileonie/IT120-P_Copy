<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index() 
    {
        Session::put('topbar', 'Home');

        //if logged in, go to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('home');
    }

    public function about() 
    {
        Session::put('topbar', 'About');
        return view('about');
    }

    public function contactus() 
    {
        Session::put('topbar', 'Contact');
        return view('contactus');
    }
}