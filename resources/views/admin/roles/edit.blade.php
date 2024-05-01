@extends(Auth::check() ? 'layouts.auth' : 'layouts.guest')
@section('content')
    <x-admin.section-header :title="label('role_edit') . ': ' . $role->name" />

    <x-admin.page>
        <x-form.form id="update-role" :route="['roles.update', $role->id]" method="put" full_form="true">
            <div class="row mb-3">
                <div class="col-md-6">
                    <x-form.input name="name" :inline="false" label="name" :value="$role->name" disabled />
                </div>
            </div>

            <h5 class="mb-3">{{ label('permission:plural') }}</h5>
            @if (count($permissions) > 1)
                <x-form.checkbox name="flexCheck_all" id="flexCheck_all" label="all_permissions" value="1" />
            @endif
            <div class="row" id="permissions">
                @foreach ($permissions as $perm)
                    <div class="col-md-3">
                        <x-form.checkbox name="permissions[]" id="flexCheck_{{ $perm->id }}" :text="$perm->name" :value="$perm->id" :value_set="$role_permissions" />
                    </div>
                @endforeach
            </div>
        </x-form.form>
    </x-admin.page>

    @include('admin.roles.scripts')
@endsection