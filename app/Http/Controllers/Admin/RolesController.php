<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Traits\GeneralTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    use GeneralTrait;

    const MAIN_NAV          = 'System Users';
    const SUB_NAV           = 'Roles';
    const VIEW_DIR          = 'admin.roles.';
    const ROUTE             = 'roles.';
    const PERMISSION_PREFIX = 'roles_';


    public function __construct()
    {
        $this->setSidebarActiveLink(self::MAIN_NAV, self::SUB_NAV);
    }


    public function index(Request $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'index');

        if ($request->ajax()) {
            return Role::dataTablesOf($request)->make(true);
        }
        return view(self::VIEW_DIR . 'index');
    }


    public function create()
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');

        $permissions = Permission::all();
        return view(self::VIEW_DIR . 'create', compact('permissions'));
    }


    public function store(StoreRoleRequest $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');

        DB::beginTransaction();
        try {
            // create role
            $role = Role::create($request->all());

            // check if we have permissions
            if($request->has('permissions') && ! empty(array_filter($request->permissions)))
            {
                // prepare created fields
                $created_fields = [
                    'created_at' => now()->toDateTimeString(),
                    'created_by' => auth()->id() ?? 0
                ];

                // attach permissions
                $role->permissions()->attach(array_filter($request->permissions) ?? [], $created_fields);
            }

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
                ->with('formMsg', message('record_created', ['record' => label('role') ]));
    }


    public function edit(Role $role)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');

        //get permissions
        $permissions = Permission::all();

        //get role permissions
        $role_permissions = $role->permissions?->pluck('id')?->toArray();
        if (is_null($role_permissions)) {
            $role_permissions = [];
        }

        return view(self::VIEW_DIR . 'edit', compact('role','permissions','role_permissions'));
    }


    public function update(UpdateRoleRequest $request, Role $role)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');

        // get role permissions
        $role_permissions = $role->permissions?->pluck('id')?->toArray();
        if (is_null($role_permissions)) {
            $role_permissions = [];
        }

        DB::beginTransaction();
        try {

            // apply role permissions
            if($request->has('permissions') && ! empty(array_filter($request->permissions))){

                // prepare created fields
                $created_fields = [
                    'created_at' => now()->toDateTimeString(),
                    'created_by' => auth()->id() ?? 0
                ];

                // check if we have existing permissions
                if (! empty($role_permissions)) {

                    // filtered permissions
                    $filtered_permissions = array_filter(array_map('intval', $request->permissions));

                    // let's differentiate to check if we have new
                    $new_permissions = array_diff($filtered_permissions, $role_permissions);
                    if (count($new_permissions)) {

                        // let's attach new permissions
                        $role->permissions()->attach($new_permissions, $created_fields);
                    }

                    // let's differentiate to check delete ones
                    $delete_permissions = array_diff($role_permissions, $filtered_permissions);
                    if (count($delete_permissions)) {

                        // let's delete old discounts
                        PermissionRole::where('role_id', $role->id)
                            ->whereIn('permission_id', $delete_permissions)
                            ->delete();
                    }

                } else {
                    // attach all
                    $role->permissions()->attach(array_filter($request->permissions) ?? [], $created_fields);
                }

            } else {
                // delete permissions
                PermissionRole::where('role_id', $role->id)->delete();
            }

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
                ->with('formMsg', message('record_updated', [ 'record' => label('role')]));
    }


    public function show(Role $role)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'show');
        return view(self::VIEW_DIR . 'show', compact('role'));
    }


    public function destroy(Role $role)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'delete');

        DB::beginTransaction();
        try {
            // delete permissions
            PermissionRole::where('role_id', $role->id)->delete();

            // delete role
            $role->delete();

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()
                    ->back()
                    ->withErrors([message('unprocessable')]);
        }
        DB::commit();

        return redirect()
                ->route(self::ROUTE . 'index')
                ->with('formMsg', message('record_deleted', [ 'record' => label('role') ]) );
    }


    public function rolePermissions(Role $role)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'index');

        $permissions = PermissionRole::select('permissions.*')
                        ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                        ->where('permission_role.role_id', '=', $role->id)
                        ->get();

        return view(self::VIEW_DIR . 'modals.permissions', compact('permissions'));
    }

}