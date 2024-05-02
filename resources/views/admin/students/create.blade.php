@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="student_new" />
    <x-admin.page>
        <x-form.form id="create-student" route="students.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection