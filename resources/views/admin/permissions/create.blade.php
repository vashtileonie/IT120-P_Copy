@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="permission_add" />

    <x-admin.page>
        <x-form.form id="create-permission" route="permissions.store">
            <x-form.input name="name" :inline="false" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection