@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="user_new" />
    <x-admin.page>
        <x-form.form id="create-user" route="users.store" full_form="true">
            <div class="row">
                <div class="col-md-6">
                    <x-form.input name="user_refno" label="user_refno" />
                    <x-form.input name="first_name" label="first_name" required />
                    <x-form.input name="last_name" label="last_name" required />
                    <x-form.input type="email" name="email" label="email" required />
                    <x-form.input name="phone_number" label="phone" />
                    <x-form.input name="mobile_number" label="mobile" required />
                </div>
                <div class="col-md-6">
                    <x-form.input name="username" label="username" required />
                    <x-form.input type="password" name="password" label="password" required />
                    <x-form.input type="password" name="password_confirmation" label="confirm_password" required />
                    <x-form.select name="role_id" label="role" :list="$roles" empty_first="true" required />
                </div>
            </div>
        </x-form.form>
    </x-admin.page>
@endsection

@pushOnce('scripts')
    @include('admin.users.scripts')
@endPushOnce