<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\EmployeeStatus;
use App\Http\Requests\StoreEmployeeStatusRequest;
use App\Http\Requests\UpdateEmployeeStatusRequest;
use App\Traits\AuthUserTrait;
use App\Traits\GeneralTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmployeeStatusesController extends Controller
{
    use GeneralTrait, AuthUserTrait;

    const NAV_MAIN          = 'Settings';
    const NAV_SUB           = 'Employee Statuses';
    const ACCESS_PREFIX     = 'employee_statuses_';
    const PERMISSION_PREFIX = 'employee_statuses_';
    const VIEW_DIR          = 'admin.employee_statuses.';
    const RESOURCE_PREFIX   = 'employee_statuses.';

  
    public function __construct()
    {
        $this->setSidebarActiveLink(self::NAV_MAIN, self::NAV_SUB);
    }


    public function index(Request $request): JsonResponse|View
    {
        abortNoAccess(self::ACCESS_PREFIX . 'index');

        if ($request->ajax()) {
            return EmployeeStatus::dataTablesOf($request)->make(true);
        }

        return view(self::VIEW_DIR . 'index');
    }


    public function create()
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');
        return view(self::VIEW_DIR . 'create');
    }


    public function store(StoreEmployeeStatusRequest $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');

        DB::beginTransaction();
        try {
            //insert to DB
            $row = EmployeeStatus::create($request->all());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withErrors([message('unprocessable')]);
        }
        DB::commit();

        return redirect()
                ->route(self::ROUTE . 'index')
                ->with('formMsg', message('record_created', ['record' => label('employee_status') ]));
    }


    public function edit(EmployeeStatus $employee_status)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');
        return view(self::VIEW_DIR . 'edit', compact('employee_status'));
    }


    public function update(UpdateEmployeeStatusRequest $request, EmployeeStatus $employee_status)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');

        DB::beginTransaction();
        try {
            // prepare data
            $data = $request->all();
            $employee_status->update($data);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withErrors([message('unprocessable')]);
        }
        DB::commit();

        return redirect()
                ->route(self::ROUTE . 'index')
                ->with('formMsg', message('record_updated', [ 'record' => label('employee_status')]));
    }


    public function show(EmployeeStatus $employee_status)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'show');
        return view(self::VIEW_DIR . 'show', compact('employee_status'));
    }


    public function destroy(EmployeeStatus $employee_status)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'delete');

        DB::beginTransaction();
        try {
            // delete from DB
            $program->delete();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                    ->back()
                    ->withErrors([message('unprocessable')]);
        }
        DB::commit();

        return redirect()
                ->route(self::ROUTE . 'index')
                ->with('formMsg', message('record_deleted', [ 'record' => label('employee_status') ]) );
    }
}