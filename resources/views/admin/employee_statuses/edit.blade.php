@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('department_edit') . ': ' . $department->name" />
    <x-admin.page>
        <x-form.form id="update-department" :route="['departments.update', $department->id]" method="put">
            <x-form.input name="name" label="name" :value="$department->name" required />
        </x-form.form>
    </x-admin.page>
@endsection