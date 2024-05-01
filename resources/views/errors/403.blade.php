@extends(Auth::check() ? 'layouts.auth' : 'layouts.guest')
@section('content')

    <div class="text-center" style="margin-top:5rem;">
        <div class="error mx-auto" data-text="403">403</div>
        <p class="lead text-gray-800 mb-5">You have no permission to access this page</p>
        <p class="text-gray-500 mb-0">Kindly contact system administrator</p>
        <a href="/">← Back to Dashboard</a>
    </div>

@endsection