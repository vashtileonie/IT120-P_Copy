@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="subject_new" />
    <x-admin.page>
        <x-form.form id="create-subject" route="subjects.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection