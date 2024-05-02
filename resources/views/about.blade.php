@extends('layouts.guest')
@section('content')

    <header class="mt-10">
        <img src="{!! url('assets/images/banner-about.svg') !!}" alt="Your Banner Image">
    </header>

    <!-- About Us Section -->
    <div class="container-fluid mt-5 pt-5 custom-background">
        <div class="row">
            <div class="col-md-6 ">
                <img src="{!! url('assets/images/CSA.jpg') !!}" class="d-block w-100 mb-5" alt="Image 1">
            </div>
          
            <div class="col-md-6 mt-md-0 mt-3 ">
                <div class="pl-md-4">
                    <h2 class="text-left about-heading mb-0 mt-4 text-white"><strong>CSA</strong></h2>
                    <h2 class="text-left about-heading mt-5 text-white"><strong>TEAM</strong></h2>
                
                    <p class="justify-text mt-4  text-black">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis malesuada nisl. Phasellus mauris ligula, tristique vel nunc eget, tincidunt ultrices arcu. Pellentesque non auctor velit. Suspendisse potenti. Etiam eget dignissim lectus. Suspendisse vitae interdum nunc.
                    </p>
                
                    <p class="justify-text text-black">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis malesuada nisl. Phasellus mauris ligula, tristique vel nunc eget, tincidunt ultrices arcu. Pellentesque non auctor velit. Suspendisse potenti. Etiam eget dignissim lectus. Suspendisse vitae interdum nunc.
                    </p>
                    
                    <p class="justify-text mb-5 text-black">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis malesuada nisl. Phasellus mauris ligula, tristique vel nunc eget, tincidunt ultrices arcu. Pellentesque non auctor velit. Suspendisse potenti. Etiam eget dignissim lectus. Suspendisse vitae interdum nunc.
                    </p>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="container mt-4 pt-5 mb-5">
        <h2 class="text-center mb-4 meet-heading"><strong> Nice to Meet You.</strong></h2>
        <div class="row">
            <div class="col-md-3 mb-5">
                <div class="card">
                    <img src="{!! url('assets/images/person.svg') !!}" alt="Team Member 1" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">ARLENE C. MACATUGGAL, RGc, Rpm</h5>
                        <p class="card-text">Director, Center for Student Advising & Counseling</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{!! url('assets/images/person.svg') !!}" alt="Team Member 2" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Ellen Aubrey Z. Respicio</h5>
                        <p class="card-text">CSA Coordinator</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{!! url('assets/images/person.svg') !!}" alt="Team Member 3" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Justine Louise M. Muñoz</h5>
                        <p class="card-text">CSA Staff - Intramuros</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{!! url('assets/images/person.svg') !!}" alt="Team Member 3" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Jennifer P. Tecson</h5>
                        <p class="card-text">CSA Staff – Makati</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{!! url('assets/images/person.svg') !!}" alt="Team Member 3" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Aileen A. Broqueza</h5>
                        <p class="card-text">Life Coach (CpE-O & IE-O)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{!! url('assets/images/person.svg') !!}" alt="Team Member 3" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Leanna Mae A. Cruz</h5>
                        <p class="card-text">Life Coach (CS-O & IT-O)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="{!! url('assets/images/person.svg') !!}" alt="Team Member 3" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Kimberly Anne E. Oliveros</h5>
                        <p class="card-text">Life Coach (ECE-O & EE-O)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection