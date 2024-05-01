@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="priority:plural">
        <x-form.button-link name="priority_add" route="priorities.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>       
        <x-admin.data-table id="priorities-table" route="priorities.index" :columns="\App\Models\Priority::getColumns()">
            <th>{{ label('id') }}</th>
            <th>{{ label('name') }}</th>
            <th>{{ label('created_at') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')    
@endsection