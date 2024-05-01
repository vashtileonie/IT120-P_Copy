@extends('layouts.auth')
@section('content')
    <x-admin.section-header :title="label('subject_edit') . ': ' . $subject->name" />
    <x-admin.page>
        <x-form.form id="update-subject" :route="['subjects.update', $subject->id]" method="put">
            <x-form.input name="name" label="name" :value="$subject->name" required />
        </x-form.form>
    </x-admin.page>
@endsection