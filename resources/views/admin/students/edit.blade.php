@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('student_edit') . ': ' . $student->name" />
    <x-admin.page>
        <x-form.form id="update-student" :route="['students.update', $student->id]" method="put">
            <x-form.input name="name" label="name" :value="$student->name" required />
        </x-form.form>
    </x-admin.page>
@endsection