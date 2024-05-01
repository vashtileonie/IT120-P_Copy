@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="position:plural">
        <x-form.button-link name="position_add" route="positions.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>       
        <x-admin.data-table id="positions-table" route="positions.index" :columns="\App\Models\Position::getColumns()">
            <th>{{ label('id') }}</th>
            <th>{{ label('name') }}</th>
            <th>{{ label('created_at') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')    
@endsection