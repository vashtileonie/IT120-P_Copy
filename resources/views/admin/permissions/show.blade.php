@extends(Auth::check() ? 'layouts.auth' : 'layouts.guest')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> {{ trans('View Permission :') }} {{ $permission->title }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="InputName">{{ trans('Title') }}</label>
                        <input type="text" name="title" class="form-control" id="InputName" value="{{ $permission->title }}" disabled>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">{{ trans('Back') }}</a>
            </div>
        </div>
    </div>
@endsection