@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="permission:plural">
        @if ($allow_add)
            <x-form.button-link name="permission_add" route="permissions.create" icon="fas fa-plus" />
        @endif
    </x-admin.section-header>

    <x-admin.page>
        <x-admin.data-table id="permissions-table" route="permissions.index" :columns="\App\Models\Permission::getColumns()">
            <th>{{ label('name') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    <!-- Roles modal -->
    <x-modal id="rolesModal" title="permission_roles" alert="false"></x-modal>

    @include('layouts.modals.delete')

    <script>
    $(document).ready(function() {
        $(document).on('click', '.roleIcon', function () {
            var url = $(this).data('url');
            $('#rolesModal').find('.modal-body').empty().load(url);
        });
    });
    </script>
@endsection