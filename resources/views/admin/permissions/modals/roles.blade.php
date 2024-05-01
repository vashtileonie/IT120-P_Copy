<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (!is_null($roles)
                && count($roles) > 0
            )
                <ul>
                @foreach($roles as $role)
                    <li>{{ $role->name }}</li>
                @endforeach
                </ul>
            @else
                <div class="text-center">
                    {{ message('no_permission_roles') }}
                </div>
            @endif
        </div>
    </div>
</div>