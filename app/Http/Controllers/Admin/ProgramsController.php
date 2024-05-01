<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
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

class ProgramsController extends Controller
{
    use GeneralTrait, AuthUserTrait;

    const NAV_MAIN          = 'Settings';
    const NAV_SUB           = 'Programs';
    const ACCESS_PREFIX     = 'programs_';
    const PERMISSION_PREFIX = 'programs_';
    const VIEW_DIR          = 'admin.programs.';
    const RESOURCE_PREFIX   = 'programs.';

  
    public function __construct()
    {
        $this->setSidebarActiveLink(self::NAV_MAIN, self::NAV_SUB);
    }


    public function index(Request $request): JsonResponse|View
    {
        abortNoAccess(self::ACCESS_PREFIX . 'index');

        if ($request->ajax()) {
            return Program::dataTablesOf($request)->make(true);
        }

        return view(self::VIEW_DIR . 'index');
    }


    public function create()
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');
        return view(self::VIEW_DIR . 'create');
    }


    public function store(StoreProgramRequest $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');

        DB::beginTransaction();
        try {
            //insert to DB
            $row = Program::create($request->all());
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
                ->with('formMsg', message('record_created', ['record' => label('program') ]));
    }


    public function edit(Program $program)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');
        return view(self::VIEW_DIR . 'edit', compact('program'));
    }


    public function update(UpdateProgramRequest $request, Program $program)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');

        DB::beginTransaction();
        try {
            // prepare data
            $data = $request->all();
            $program->update($data);

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
                ->with('formMsg', message('record_updated', [ 'record' => label('program')]));
    }


    public function show(Program $program)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'show');
        return view(self::VIEW_DIR . 'show', compact('program'));
    }


    public function destroy(Program $program)
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
                ->with('formMsg', message('record_deleted', [ 'record' => label('program') ]) );
    }
}