@extends('layouts.guest')
@section('content')
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <x-admin.page class="p-4">
                @include('layouts.partials.errors')

                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">{{ message('forgot_password_message') }}</p>
                </div>

                <form id="forgot-password-form" method="post" action="{{ route('forgot-password.send-reset') }}" autocomplete="off"> 
                    @csrf()
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter {{ label('email_address') }}..." required autofocus>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-user btn-block">{{ label('reset_password') }}</button>
                </form>

                <hr>
                <div class="text-center">
                    <a class="small" href="{{ route('login.show') }}">{{ label('already_have_account_login') }}</a>
                </div>
            </x-admin.page>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $(document).on('submit', '#forgot-password-form', function () {
        $(this).find('button[type="submit"]').attr('disabled', true).html('<i class="fas fa-spin fa-sync-alt" aria-hidden="true"></i> Processing...');
    });
});
</script>
@endsection