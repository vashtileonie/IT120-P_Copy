@extends('layouts.auth')
@section('content')
    @php
        $active_creds_tab = false;
        if ($errors->has('username')
            || $errors->has('password')
            || $errors->has('password_confirmation')
        ) {
            $active_creds_tab = true;
        }
    @endphp

    <x-admin.section-header :title="label('user_edit') . ': ' . $user->full_name" />

    <x-admin.page>
        <ul class="nav nav-tabs" id="user-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link mr-2 {{ $active_creds_tab ? '' : 'active' }}" id="default-tab" data-toggle="tab" data-target="#default-content" type="button" role="tab" aria-controls="default-tab" aria-selected="true">{{ label('edit_details') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $active_creds_tab ? 'active' : '' }}" id="creds-tab" data-toggle="tab" data-target="#creds-content" type="button" role="tab" aria-controls="creds-tab" aria-selected="true">{{ label('change_credentials') }}</button>
            </li>
        </ul>

        <div class="tab-content" id="transaction-tabsContent">

            <div class="tab-pane pt-4 {{ $active_creds_tab ? '' : 'show active' }}" id="default-content" role="tabpanel" aria-labelledby="default-content">
                <x-form.form id="edit-user" :route="['users.update', $user->id]" method="put" full_form="true">
                    <div class="row">
                        <div class="col-md-6">
                            <x-form.input name="user_refno" label="user_refno" :value="$user->user_refno" />
                            <x-form.input name="first_name" label="first_name" :value="$user->first_name" required />
                            <x-form.input name="last_name" label="last_name" :value="$user->last_name" required />
                            <x-form.input type="email" name="email" label="email" :value="$user->email" required />
                            <x-form.input name="phone_number" label="phone" :value="$user->phone_number" />
                            <x-form.input name="mobile_number" label="mobile" :value="$user->mobile_number" required />
                        </div>
                        <div class="col-md-6">
                            @if ($is_super_admin)
                                <x-form.select name="role_id" label="role" :list="$roles" :value="$user->user_roles()->first()?->id" required />
                            @else
                                <x-form.input name="role" label="role" :value="$user->user_roles()->first()?->name" disabled />
                            @endif
                        </div>
                    </div>
                </x-form.form>
            </div>

            <div class="tab-pane pt-4 {{ $active_creds_tab ? 'show active' : '' }}" id="creds-content" role="tabpanel" aria-labelledby="default-content">
                <x-form.form id="edit-creds-user" :route="['users.update-credentials', $user->id]" method="put">
                    <x-form.input name="username" label="username" :value="$user->username" required />
                    <x-form.input type="password" name="password" label="password" required />
                    <x-form.input type="password" name="password_confirmation" label="confirm_password" required />
                </x-form.form>
            </div>
        </div>
    </x-admin.page>
@endsection

@pushOnce('scripts')
    @include('admin.users.scripts')
@endPushOnce