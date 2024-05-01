@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="role:plural">
        <x-form.button-link name="role_add" route="roles.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>
        <x-admin.data-table id="roles-table" route="roles.index" :columns="\App\Models\Role::getColumns()">
            <th>{{ label('name') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    <!-- Permissions Modal-->
    <x-modal id="permissionsModal" size="xl" title="role_permissions" alert="false"></x-modal>

    <div class="modal fade" id="permissionsModal" tabindex="-1" role="dialog" aria-labelledby="permissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionsModalLabel">Role Permissions</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    @include('layouts.modals.delete')

    <script>
    $(document).ready(function() {
        $(document).on('click', '.permIcon', function () {
            var url = $(this).data('url');
            $('#permissionsModal').find('.modal-body').empty().load(url);
        });
    });
    </script>
@endsection