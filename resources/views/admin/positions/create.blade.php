@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="position_new" />
    <x-admin.page>
        <x-form.form id="create-position" route="positions.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection