@extends(Auth::check() ? 'layouts.auth' : 'layouts.guest')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> {{ trans('View User :') }} {{ $user->full_name }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="InputFName">{{ trans('First Name') }}</label>
                        <input type="text" name="first_name" class="form-control" id="InputFName" value="{{ $user->first_name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="InputLName">{{ trans('Last Name') }}</label>
                        <input type="text" name="last_name" class="form-control" id="InputLName" value="{{ $user->last_name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="InputUsername">{{ trans('Username') }}</label>
                        <input type="text" name="username" class="form-control" id="InputUsername" value="{{ $user->username }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">{{ trans('Email') }}</label>
                        <input type="text" name="email" class="form-control" id="InputEmail" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="InputPhone">{{ trans('Phone Number') }}</label>
                        <input type="text" name="phone_number" class="form-control" id="InputPhone" value="{{ $user->phone_number }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="InputMobile">{{ trans('Mobile Number') }}</label>
                        <input type="text" name="mobile_number" class="form-control" id="InputMobile" value="{{ $user->mobile_number }}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="brandGroup">Brand:</label>
                        <select class="form-control" id="brandGroup" name="brands[]" disabled>
                            <option value="">Select from list</options>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{(in_array($brand->id, $role_brand)) ? 'selected' : '' }} >
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div><br/>

                    <h5>Roles</h5><br/>
                    <div class="container">
                        <div class="row">
                            @foreach($roles as $role)
                                <div class="col-md-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" id="flexCheck_{{ $role->id }}" type="checkbox" value="{{ $role->id }}" disabled name="roles[]" {{ (in_array($role->id, $role_user)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexCheck_{{ $role->id }}">{{ $role->title }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ trans('Back') }}</a>
            </div>
        </div>
    </div>
@endsection