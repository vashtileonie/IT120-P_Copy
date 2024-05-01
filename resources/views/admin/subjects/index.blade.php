@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="subject:plural">
        <x-form.button-link name="subject_add" route="subjects.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>       
        <x-admin.data-table id="subjects-table" route="subjects.index" :columns="\App\Models\Subject::getColumns()">
            <th>{{ label('id') }}</th>
            <th>{{ label('name') }}</th>
            <th>{{ label('created_at') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')    
@endsection