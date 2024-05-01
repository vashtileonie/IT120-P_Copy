@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="form_type:plural">
        <x-form.button-link name="form_type_add" route="form-types.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>       
        <x-admin.data-table id="form-types-table" route="form-types.index" :columns="\App\Models\FormType::getColumns()">
            <th>{{ label('id') }}</th>
            <th>{{ label('name') }}</th>
            <th>{{ label('created_at') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')    
@endsection