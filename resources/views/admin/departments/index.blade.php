@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="department:plural">
        <x-form.button-link name="department_add" route="departments.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>       
        <x-admin.data-table id="departments-table" route="departments.index" :columns="\App\Models\Department::getColumns()">
            <th>{{ label('id') }}</th>
            <th>{{ label('name') }}</th>
            <th>{{ label('created_at') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')    
@endsection