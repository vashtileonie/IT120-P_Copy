@extends('layouts.auth')

@section('content')
    <x-admin.section-header :title="$user->full_name" />

    <x-admin.page>
        <div class="row mb-3">
            <div class="col-sm-4">
                <x-admin.table>
                    <x-table.row-item label="first_name">{{ $user->first_name }}</x-table.row-item>
                    <x-table.row-item label="last_name">{{ $user->last_name }}</x-table.row-item>
                    <x-table.row-item label="email">{{ $user->email }}</x-table.row-item>
                    <x-table.row-item label="phone_number">{{ $user->phone_number }}</x-table.row-item>
                    <x-table.row-item label="mobile_number">{{ $user->mobile_number }}</x-table.row-item>
                </x-admin.table>
            </div>
            <div class="col-sm-4">
                <x-admin.table>
                    <x-table.row-item label="role">{{ $user->roles()->first()->name }}</x-table.row-item>
                    <x-table.row-item label="username">{{ $user->username }}</x-table.row-item>
                </x-admin.table>
            </div>
        </div>

        <x-form.button-link name="back" class="btn-secondary mr-2" :back="true" />
        <x-form.button-link name="edit" route="users.edit" :route_params="$user->id" />
    </x-admin.page>
@endsection