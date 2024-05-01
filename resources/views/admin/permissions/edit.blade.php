@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('permission_edit') . ': ' . $permission->name" />

    <x-admin.page>
        <x-form.form id="update-permission" :route="['permissions.update', $permission->id]" method="put">
            <x-form.input name="name" :inline="false" label="name" :value="$permission->name" required />
        </x-form.form>
    </x-admin.page>
@endsection