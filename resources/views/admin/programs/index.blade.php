@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="program:plural">
        <x-form.button-link name="program_add" route="programs.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>       
        <x-admin.data-table id="programs-table" route="programs.index" :columns="\App\Models\Program::getColumns()">
            <th>{{ label('id') }}</th>
            <th>{{ label('name') }}</th>
            <th>{{ label('created_at') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')    
@endsection