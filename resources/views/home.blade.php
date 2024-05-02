@extends('layouts.guest')
@section('content')
    <header>
        <img src="{!! url('assets/images/banner-index.svg') !!}" alt="Your Banner Image" class="banner-image">
    </header>

    <h2 class="text-center mt-5 mb-4 CSA-intro">CSA offers services to support students in addressing their academic, personal, social, and career.</h2>
    
    <!-- Team Section -->
    <div class="container mt-4 pt-5 mb-5">
        <h2 class="text-center mb-4 meet-heading"><strong> Our Services</strong></h2>
        <div class="row">
            <div class="col-md-4 mb-5 ">
                <div class="card">
                    <img src="{!! url('assets/images/peer.svg') !!}" alt="Team Member 1" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Peer Advising</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{!! url('assets/images/counseling.svg') !!}" alt="Team Member 2" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Counseling</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{!! url('assets/images/career.svg') !!}" alt="Team Member 3" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Career Advising</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection