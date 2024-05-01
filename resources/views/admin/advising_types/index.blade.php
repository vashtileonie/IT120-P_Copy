@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="advising_type:plural">
        <x-form.button-link name="advising_type_add" route="advising-types.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>
        <x-admin.data-table id="advising-types-table" route="advising-types.index" :columns="\App\Models\AdvisingType::getColumns()">
            <th>{{ label('id') }}</th>
            <th>{{ label('name') }}</th>
            <th>{{ label('created_at') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')
@endsection