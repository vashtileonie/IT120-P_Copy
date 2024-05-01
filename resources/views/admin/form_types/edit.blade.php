@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('form_type_edit') . ': ' . $form_type->name" />
    <x-admin.page>
        <x-form.form id="update-form-type" :route="['form-types.update', $form_type->id]" method="put">
            <x-form.input name="name" label="name" :value="$form_type->name" required />
        </x-form.form>
    </x-admin.page>
@endsection