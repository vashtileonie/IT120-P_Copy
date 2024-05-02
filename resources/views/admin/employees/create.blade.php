@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="employee_new" />
    <x-admin.page>
        <x-form.form id="create-employee" route="employees.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection