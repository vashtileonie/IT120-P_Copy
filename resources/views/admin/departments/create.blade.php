@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="department_new" />
    <x-admin.page>
        <x-form.form id="create-department" route="departments.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection