@extends(Auth::check() ? 'layouts.auth' : 'layouts.guest')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> {{ trans('View Role :') }} {{ $role->title }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="InputName">{{ trans('Title') }}</label>
                        <input type="text" name="title" class="form-control" id="InputName" value="{{ old('title', $role->title) }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="pinGroup">Requires PIN: &nbsp;</label>
                        <select class="form-control" id="pinGroup" name="requires_pin" disabled>
                            @foreach (\App\Models\Role::REQUIRES_PIN as $key => $label)
                                <option value="{{ $key }}" @if($role->requires_pin == $key) selected @endif>{{ trans($label) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <h5>Permissions</h5>
            <div class="container mb-3">
                <div class="row">
                    @foreach ($permissions as $perm)
                        <div class="col-md-4">
                            <div class="form-check mb-3">
                                <input disabled class="form-check-input" id="flexCheck_{{ $perm->id }}" type="checkbox" value="{{ $perm->id }}" name="permissions[]" {{ (in_array($perm->id, $role_permissions)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheck_{{ $perm->id }}">{{ trans($perm->title) }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ trans('Back') }}</a>
            </div>
        </div>
    </div>
@endsection