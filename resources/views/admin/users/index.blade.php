@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="user:plural">
        <x-form.button-link name="user_add" route="users.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>
        <x-slot:filters>
            <x-admin.form-inline id="search-users-filter" route="users.index" submit_btn_text="filter" method="get">
                <x-form.select name="role_id"
                    label="role"
                    form_group_class="mr-3"
                    empty_first="true"
                    :inline="false"
                    :list="$roles"
                    :value="request('role_id')" />
            </x-admin.form-inline>
        </x-slot:filters>

        <x-admin.data-table id="users-table" route="users.index" :route_params="$table_params" :columns="\App\Models\User::getColumns()">
            <th>{{ label('username') }}</th>
            <th>{{ label('first_name') }}</th>
            <th>{{ label('last_name') }}</th>
            <th>{{ label('email') }}</th>
            <th>{{ label('phone') }}</th>
            <th>{{ label('mobile') }}</th>
            <th>{{ label('role') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')    
@endsection