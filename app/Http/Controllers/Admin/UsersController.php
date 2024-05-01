<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\User;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserCredentialsRequest;
use App\Http\Requests\UpdateUserRequest;
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

class UsersController extends Controller
{
    use GeneralTrait, AuthUserTrait;

    const NAV_MAIN          = 'System Users';
    const NAV_SUB           = 'Users';
    const ACCESS_PREFIX     = 'users_';
    const VIEW_PREFIX       = 'admin.users.';
    const RESOURCE_PREFIX   = 'users.';

  
    public function __construct()
    {
        $this->setSidebarActiveLink(self::NAV_MAIN, self::NAV_SUB);
    }


    /**
     * List of Users
     *
     * @param Request $request
     * @return JsonResponse|View
     */
    public function index(Request $request): JsonResponse|View
    {
        abortNoAccess(self::ACCESS_PREFIX . 'index');

        if ($request->ajax()) {
            return User::dataTablesOf($request)->make(true);
        }

        $roles = Role::getDataProvider();
        $table_params = [
            'role_id' => $request->role_id
        ];

        return view(self::VIEW_PREFIX . 'index', compact('roles','table_params'));
    }


    public function create(): View
    {
        abortNoAccess(self::ACCESS_PREFIX . 'create');

        $roles = Role::getDataProvider();
        return view(self::VIEW_PREFIX . 'create', compact('roles'));
    }


    /**
     * Store a User Request
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        abortNoAccess(self::ACCESS_PREFIX . 'create');

        DB::beginTransaction();
        try {

            // prepare data
            $data = $request->all();

            // get role
            $role = Role::find((int) $request->role_id);
            
            // create user
            $user = User::create($data);

            // sync role
            $user->user_roles()->sync([$request->role_id]);

        } catch(\Exception $e) {

            DB::rollBack();
            return redirect()
                    ->back()
                    ->withErrors([message('unprocessable')]);
        }

        DB::commit();
        return redirect()
                ->route(self::RESOURCE_PREFIX . 'index')
                ->with('formMsg', message('record_created', [
                                    'record' => label('user')
                                ])
                            );
    }


    public function show(User $user)
    {
        abortNoAccess(self::ACCESS_PREFIX . 'show');

        /*
        // check if authorized
        self::checkRelatedRecord($user);

        $brands = Brand::byUser($this->user_brands);

        $roles  = Role::all();

        $role_user = [];
        foreach($user->roles as $key => $val){
            $role_user[] = $val->id;
        }

        $role_brand = [];
        foreach($user->brands as $key => $val){
            $role_brand[] = $val->id;
        }

        return view(self::VIEW_PREFIX . 'show', compact(
                                                'user',
                                                'brands',
                                                'roles',
                                                'role_user',
                                                'role_brand'
                                            )
                                        );
        */
    }


    /**
     * Edit a User
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        // if user is not editing itself
        if ($user->id != auth()->id()) {
            abortNoAccess(self::ACCESS_PREFIX . 'edit');
        }

        // if user is super admin
        $is_super_admin = $this->isSuperAdmin();

        // prepare roles
        $roles = Role::getDataProvider();

        return view(self::VIEW_PREFIX . 'edit', compact('user','is_super_admin','roles'));
    }


    /**
     * Updates a User
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // if editor is not self
        if ($user->id != auth()->id()) {
            abortNoAccess(self::ACCESS_PREFIX . 'edit');
        }

        // if super admin
        $is_super_admin = $this->isSuperAdmin();

        DB::beginTransaction();
        try {
            // prepare request params
            $request_params = [
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'mobile_number',
            ];

            // prepare data
            $data = $request->only($request_params);

            // if account edited is super admin
            $is_super_admin_role = false;

            // validate role
            if ($request->has('role_id')) {
                $role = Role::find((int) $request->role_id);
                if (! is_null($role)
                    && $role->name == Role::SUPER_ADMIN
                ) {
                    $is_super_admin_role = true;
                }
            }

            // update
            $user->update($data);

            // check if super admin
            if ($is_super_admin) {
                $user->user_roles()->sync([$request->role_id]);
            }
        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()
                    ->back()
                    ->withErrors([message('unprocessable')]);
        }
        DB::commit();

        // if editor is self
        if ($user->id == auth()->id()) {
            // redirect same page
            return redirect()
                ->route(self::RESOURCE_PREFIX . 'edit', $user->id)
                ->with('formMsg', message('record_updated', [
                                    'record' => label('account')
                                ])
                            );
        }

        return redirect()
                ->route(self::RESOURCE_PREFIX . 'index')
                ->with('formMsg', message('record_updated', [
                                    'record' => label('user')
                                ])
                            );
    }


    /**
     * Updates a User's credentials
     *
     * @param UpdateUserCredentialsRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function updateCredentials(UpdateUserCredentialsRequest $request, User $user): RedirectResponse
    {
        // if editor is not self
        if ($user->id != auth()->id()) {
            abortNoAccess(self::ACCESS_PREFIX . 'edit');
        }

        // update
        $user->update($request->only(['username', 'password']));

        // if user account is logged-in user
        if ($user->id == auth()->id()) {

            // log out
            Session::flush();
            Auth::logout();

            // redirect out
            return redirect()
                    ->route('login.show')
                    ->with('formMsg', message('credentials_changed'));
        }

        return redirect()
                ->route(self::RESOURCE_PREFIX . 'index')
                ->with('formMsg', message('record_updated', ['record' => label('user')]));
    }


    /**
     * Delets a User
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        abortNoAccess(self::ACCESS_PREFIX . 'delete');

        // begin trans
        DB::beginTransaction();
        try {
            // update deleted email
            $user->deleteEmail();

            // delete
            $user->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                    ->back()
                    ->withErrors([message('unprocessable')]);
        }

        DB::commit();
        return redirect()
                ->route(self::RESOURCE_PREFIX . 'index')
                ->with('formMsg', message('record_deleted', [
                                    'record' => label('user')
                                ])
                            );
    }


    /**
     * View Logged in User Profile page
     *
     * @return View
     */
    public function profile(): View
    {
        $user = auth()->user();
        return view(self::VIEW_PREFIX . 'profile', compact('user'));
    }
}