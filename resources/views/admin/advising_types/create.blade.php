@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="advising_type_new" />
    <x-admin.page>
        <x-form.form id="create-advising-type" route="advising-types.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection