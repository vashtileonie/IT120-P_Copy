@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('advising_type_edit') . ': ' . $advising_type->name" />
    <x-admin.page>
        <x-form.form id="update-advising-type" :route="['advising-types.update', $advising_type->id]" method="put">
            <x-form.input name="name" label="name" :value="$advising_type->name" required />
        </x-form.form>
    </x-admin.page>
@endsection