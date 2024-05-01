<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Traits\AuthUserTrait;
use App\Traits\GeneralTrait;

use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    use AuthUserTrait, GeneralTrait;

    const MAIN_NAV = 'System Users';
    const SUB_NAV = 'Permissions';
    const VIEW_DIR = 'admin.permissions.';
    const ROUTE = 'permissions.';
    const PERMISSION_PREFIX = 'permissions_';


    public function __construct()
    {
        $this->setSidebarActiveLink(self::MAIN_NAV, self::SUB_NAV);
    }


    public function index(Request $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'index');

        if ($request->ajax()) {
            return Permission::dataTablesOf($request)->make(true);
        }

        // if do we allow adding of permission
        $allow_add = $this->isSuperAdmin();

        return view(self::VIEW_DIR . 'index', compact('allow_add'));
    }

    public function create()
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');

        return view(self::VIEW_DIR . 'create');
    }

    public function store(StorePermissionRequest $request)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'create');

        Permission::create($request->all());

        return redirect()
                ->route(self::ROUTE . 'index')
                ->with('formMsg', message('record_created', [
                                    'record' => label('permission')
                                    ])
                                );
    }

    public function edit(Permission $permission)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');

        return view(self::VIEW_DIR . 'edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'edit');

        $permission->update($request->all());

        return redirect()
                ->route(self::ROUTE . 'index')
                ->with('formMsg', message('record_updated', [
                                    'record' => label('permission')
                                ])
                            );
    }

    public function show(Permission $permission)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'show');

        return view(self::VIEW_DIR . 'show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'delete');

        $permission->delete();

        return redirect()
                ->route(self::ROUTE . 'index')
                ->with('formMsg', message('record_deleted', [
                                    'record' => label('permission')
                                ])
                            );
    }

    public function permissionRoles(Permission $permission)
    {
        abortNoAccess(self::PERMISSION_PREFIX . 'index');

        $roles = PermissionRole::select('roles.*')
                    ->join('roles', 'roles.id', '=', 'permission_role.role_id')
                    ->where('permission_role.permission_id', '=', $permission->id)
                    ->get();

        return view(self::VIEW_DIR . 'modals.roles', compact('roles'));
    }
}