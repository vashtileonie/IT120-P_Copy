@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('priority_edit') . ': ' . $priority->name" />
    <x-admin.page>
        <x-form.form id="update-priority" :route="['priorities.update', $priority->id]" method="put">
            <x-form.input name="name" label="name" :value="$priority->name" required />
        </x-form.form>
    </x-admin.page>
@endsection