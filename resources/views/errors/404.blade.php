@extends(Auth::check() ? 'layouts.auth' : 'layouts.guest')
@section('content')

    <div class="text-center" style="margin-top:5rem;">
        <div class="error mx-auto" data-text="404">404</div>
        <p class="lead text-gray-800 mb-5">Page Not Found</p>
        <p class="text-gray-500 mb-0">Kindly contact system administrator.</p>
        <a href="/">← Back to Dashboard</a>
    </div>
    
@endsection