@extends('layouts.guest')
@section('content')
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <x-admin.page class="p-4">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">{{ label('reset_password') }}</h1>
                    <p class="mb-1">{{ message('fill_all_details') }}</p>
                </div>

                <x-form.form id="reset-password-form" route="password.update" :basecontrol="false" full_form="true" autocomplete="off">
                    <x-form.input type="hidden" name="token" :inline="false" :value="$token" />
                    <x-form.input type="hidden" name="email" :inline="false" :value="$email" />
                    <x-form.input type="password" name="password" label="new_password" :inline="false" required />
                    <x-form.input type="password" name="password_confirmation" label="confirm_new_password" :inline="false" required />

                    <x-slot:extra_buttons>
                        <div class="form-group text-center">
                            <div class="g-recaptcha d-inline-block" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        </div>

                        <button type="submit" class="btn btn-secondary btn-block">{{ label('submit') }}</button>
                    </x-slot:extra_buttons>
                </x-form.form>

                <hr>
                <div class="text-center">
                    <a class="small" href="{{ route('login.show') }}">{{ label('already_have_account_login') }}</a>
                </div>
            </x-admin.page>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
    $(document).ready(function () {
        $(document).on('submit', '#reset-password-form', function () {
            $(this).find('button[type="submit"]').attr('disabled', true).html('<i class="fas fa-spin fa-sync-alt" aria-hidden="true"></i> Submitting...');
        });
    });
    </script>
@endsection