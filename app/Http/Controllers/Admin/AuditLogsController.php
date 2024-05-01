<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\AuditLog;
use App\Traits\DataTableTrait;
use App\Traits\FilterTrait;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class AuditLogsController extends Controller
{
    use DataTableTrait, FilterTrait;

    protected $includeDefaultColumns = false;

    public function __construct()
    {
        $this->setSidebarActiveLink('Logs', 'Audit Logs');
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('audit_logs_index'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $logs = AuditLog::search()
                    ->skip($request->get('start', 0))
                    ->take($request->get('length', 10))
                    ->get();

            return $this->dataTablesOf($logs)
                        ->editColumn('user.first_name', function (AuditLog $log) {
                            return optional($log->user)->first_name . ' ' . optional($log->user)->last_name;
                        })
                        ->make(true);
        }

        return view('admin.audit_logs.index');
    }


    private function getRecordsTotal(): int
    {
        return AuditLog::count();
    }


    private function getRecordsFiltered(): int
    {
        return AuditLog::search()->count();
    }
}
