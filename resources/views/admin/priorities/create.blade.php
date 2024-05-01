@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="priority_new" />
    <x-admin.page>
        <x-form.form id="create-priority" route="priorities.store">
            <x-form.input name="name" label="name" required />
        </x-form.form>
    </x-admin.page>
@endsection