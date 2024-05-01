<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {

        // if logged in, go to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return view('home');
    }
}