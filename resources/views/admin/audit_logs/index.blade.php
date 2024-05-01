@extends(Auth::check() ? 'layouts.auth' : 'layouts.guest')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ trans('Audit Logs') }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('All Audit Logs') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable" width="100%" cellspacing="0" data-ajax="{{ route('audit-logs.index') }}" data-columns="{{ json_encode((new \App\Models\AuditLog())->getDataTableColumns(), JSON_HEX_TAG) }}">
                    <thead>
                        <tr>
                            <th>{{ trans('User') }}</th>
                            <th>{{ trans('Host') }}</th>
                            <th>{{ trans('Description') }}</th>
                            <th>{{ trans('Type') }}</th>
                            <th>{{ trans('Properties') }}</th>
                            <th>{{ trans('Date Logged') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>


@endsection