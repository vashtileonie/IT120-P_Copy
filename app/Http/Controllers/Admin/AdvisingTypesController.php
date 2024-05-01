<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\AdvisingType;
use App\Http\Requests\StoreAdvisingTypeRequest;
use App\Http\Requests\UpdateAdvisingTypeRequest;
use App\Traits\GeneralTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdvisingTypesController extends Controller
{
    use GeneralTrait;

    const MAIN_NAV          = 'Settings';
    const SUB_NAV           = 'Advising Types';
    const VIEW_DIR          = 'admin.advising_types.';
    const ROUTE             = 'advising-types.';
    const PERMISSION_PREFIX = 'advising_types_';


    public function __construct()
    {
        $this->setSidebarActiveLink(self::MAIN_NAV, self::SUB_NAV);
    }


    public function index(Request $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'index');
        if ($request->ajax()) {
            return AdvisingType::dataTablesOf($request)->make(true);
        }
        return view(self::VIEW_DIR . 'index');
    }


    public function create()
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');
        return view(self::VIEW_DIR . 'create');
    }


    public function store(StoreAdvisingTypeRequest $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');

        DB::beginTransaction();
        try {
            //insert to DB
            $row = AdvisingType::create($request->all());
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
                ->with('formMsg', message('record_created', ['record' => label('advising_type') ]));
    }


    public function edit(AdvisingType $advising_type)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');
        return view(self::VIEW_DIR . 'edit', compact('advising_type'));
    }


    public function update(UpdateAdvisingTypeRequest $request, AdvisingType $advising_type)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');

        DB::beginTransaction();
        try {
            
            $data = $request->all();
            $advising_type->update($data);

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
                ->with('formMsg', message('record_updated', [ 'record' => label('advising_type')]));
    }


    public function show(AdvisingType $advising_type)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'show');
        return view(self::VIEW_DIR . 'show', compact('advising_type'));
    }


    public function destroy(AdvisingType $advising_type)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'delete');

        DB::beginTransaction();
        try {
            // delete from DB
            $advisingType->delete();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                    ->back()
                    ->withErrors([message('unprocessable')]);
        }
        DB::commit();

        return redirect()
                ->route(self::ROUTE . 'index')
                ->with('formMsg', message('record_deleted', [ 'record' => label('advising_type') ]) );
    }
}