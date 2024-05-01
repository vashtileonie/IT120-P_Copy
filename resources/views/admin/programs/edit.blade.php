@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('program_edit') . ': ' . $program->name" />
    <x-admin.page>
        <x-form.form id="update-program" :route="['programs.update', $program->id]" method="put">
            <x-form.input name="name" label="name" :value="$program->name" required />
        </x-form.form>
    </x-admin.page>
@endsection