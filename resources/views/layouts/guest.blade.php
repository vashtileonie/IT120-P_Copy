<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Management System for Mapua CSA">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Mapúa University - Center of Student Advising</title>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        
        <link rel="stylesheet" href="{!! url('css/bootstrap.min.css') !!}">
        <link rel="stylesheet" href="{!! url('css/sb-admin-2.min.css') !!}">
        <link rel="stylesheet" href="{!! url('css/guest.css') !!}">
        <link rel="stylesheet" href="{!! url('css/home.css') !!}">
        <link rel="stylesheet" href="{!! url('css/about.css') !!}">
        <link rel="stylesheet" href="{!! url('css/contact.css') !!}">

        @yield('styles')
    </head>

    <body class="bg-gradient-light">

        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand">
                <img src="{!! url('assets/images/logo.svg') !!}" height="50px" alt="Your Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item @if(session()->get('topbar') == 'Home') active @endif">
                        <a class="nav-link" href="{{ route('home.index') }}">Home</a>
                    </li>
                    <li class="nav-item @if(session()->get('topbar') == 'About') active @endif">
                        <a class="nav-link" href="{{ route('home.about') }}">About</a>
                    </li>
                    <li class="nav-item @if(session()->get('topbar') == 'Contact') active @endif">
                        <a class="nav-link" href="{{ route('home.contactus') }}">Contact</a>
                    </li>
                </ul>
            </div>
            @if(session()->get('topbar') != 'Login')
                <a class="btn btn-outline-danger ml-2" href="{{ route('login.show') }}">Login</a>
            @endif
        </nav>

        <div class="container">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts.partials.footer')

        <script src="{!! url('js/jquery-3.6.0.js') !!}"></script>
        <script src="{!! url('js/jquery-ui.js') !!}"></script>
        <script src="{!! url('js/bootstrap.min.js') !!}"></script>
        <script src="{!! url('js/popper.min.js') !!}"></script>
        <script src="{!! url('js/sb-admin-2.min.js') !!}"></script>
        
        @yield('scripts')
    </body>
</html>