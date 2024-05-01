@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="form_type_new" />
    <x-admin.page>
        <x-form.form id="create-form-type" route="form-types.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection