@extends('layouts.guest')
@section('content')

    <!-- Contact Information Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-left mb-1 contact-heading"><strong>Contact</strong></h2>
                <h2 class="text-left mb-4 mt-4 contact-heading"><strong>Information</strong></h2>
                <div class="contact-info">
                    <p><strong>Telephone</strong></p>
                    <p><em>+63(2) 8891-0837; +63(2) 8891-0843 loc 72300</em></p>
                    <p><strong>Email</strong></p>
                    <p><em>csa&#64;mapua.edu.ph</em></p>
                    <p><strong>Facebook</strong></p>
                    <p><em>MAPUA- Center for Student Advising</em></p>
                    <p><strong>Makati Campus</strong></p>
                    <p><em>2nd Floor, Room 215</em></p>
                </div>
            </div>
            <!-- Email Inquiry -->
            <div class="col-md-6">
                <div class="inquiry-area">
                    <form [formGroup] ="form" id="inquiryForm" action="javascript:void(0)" (submit)="send()">
                        <h3 style="color: #940C0C"><strong>Ask us anything!</strong></h3>
                        <input formControlName="from_email" type="email" name="email" placeholder="Your email">
                        <textarea formControlName="message" name="inquiry" placeholder="Write your inquiry here"></textarea>
                        <button type="submit" class="btn btn-danger mt-3 custom-button">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection