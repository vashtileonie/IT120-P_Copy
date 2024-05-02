@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('employee_edit') . ': ' . $employee->name" />
    <x-admin.page>
        <x-form.form id="update-employee" :route="['employees.update', $employee->id]" method="put">
            <x-form.input name="name" label="name" :value="$employee->name" required />
        </x-form.form>
    </x-admin.page>
@endsection