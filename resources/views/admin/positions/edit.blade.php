@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('position_edit') . ': ' . $position->name" />
    <x-admin.page>
        <x-form.form id="update-position" :route="['positions.update', $position->id]" method="put">
            <x-form.input name="name" label="name" :value="$position->name" required />
        </x-form.form>
    </x-admin.page>
@endsection