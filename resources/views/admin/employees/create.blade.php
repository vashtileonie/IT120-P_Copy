@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="program_new" />
    <x-admin.page>
        <x-form.form id="create-program" route="programs.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection