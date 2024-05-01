@extends(Auth::check() ? 'layouts.auth' : 'layouts.guest')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Mapua CSA</h1>
                                </div>

                                @include('layouts.partials.messages')
                                @include('layouts.partials.success')

                                <form class="user" name="loginForm" id="loginForm" method="POST" action="{{route('login.perform')}}"> 
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="inputEmail" placeholder="Username" name="username" value="{{ old('username') }}" required="required" autofocus>
                                        @if ($errors->has('username'))
                                            <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="inputPassword" placeholder="Password" name="password" value="{{ old('password') }}" required="required">
                                        @if ($errors->has('password'))
                                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-user btn-block">Login</button>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="#">
                                        Forgot Password?
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection