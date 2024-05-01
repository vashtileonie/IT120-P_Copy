<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
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

class PositionsController extends Controller
{
    use GeneralTrait, AuthUserTrait;

    const NAV_MAIN          = 'Settings';
    const NAV_SUB           = 'Positions';
    const ACCESS_PREFIX     = 'positions_';
    const PERMISSION_PREFIX = 'positions_';
    const VIEW_DIR          = 'admin.positions.';
    const RESOURCE_PREFIX   = 'positions.';

  
    public function __construct()
    {
        $this->setSidebarActiveLink(self::NAV_MAIN, self::NAV_SUB);
    }


    public function index(Request $request): JsonResponse|View
    {
        abortNoAccess(self::ACCESS_PREFIX . 'index');

        if ($request->ajax()) {
            return Position::dataTablesOf($request)->make(true);
        }

        return view(self::VIEW_DIR . 'index');
    }


    public function create()
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');
        return view(self::VIEW_DIR . 'create');
    }


    public function store(StorePositionRequest $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');

        DB::beginTransaction();
        try {
            //insert to DB
            $row = Position::create($request->all());
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
                ->with('formMsg', message('record_created', ['record' => label('position') ]));
    }


    public function edit(Position $position)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');
        return view(self::VIEW_DIR . 'edit', compact('position'));
    }


    public function update(UpdatePositionRequest $request, Position $position)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');

        DB::beginTransaction();
        try {
            // prepare data
            $data = $request->all();
            $position->update($data);

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
                ->with('formMsg', message('record_updated', [ 'record' => label('position')]));
    }


    public function show(Position $position)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'show');
        return view(self::VIEW_DIR . 'show', compact('position'));
    }


    public function destroy(Position $position)
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
                ->with('formMsg', message('record_deleted', [ 'record' => label('position') ]) );
    }
}