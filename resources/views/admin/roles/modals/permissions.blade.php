<div class="container">
    <div class="row">
        @if (!is_null($permissions)
            && count($permissions) > 0
        )
            @foreach($permissions as $perm)
                <div class="col-md-3 mb-3">{{ $perm->name }}</div>
            @endforeach
        @else
            <div class="col-md-12 text-center">
                {{ message('no_role_permissions') }}
            </div>
        @endif
    </div>
</div>