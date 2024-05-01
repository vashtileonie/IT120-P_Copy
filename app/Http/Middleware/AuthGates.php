<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        // get user
        $user = Auth::user();

        if (! app()->runningInConsole()
            && $user
        ) {
            // get roles
            $roles = Role::with('permissions')->get();

            $permissionsArray = [];
            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->name][] = $role->id;
                }
            }

            foreach ($permissionsArray as $name => $roles) {
                Gate::define($name, function (User $user) use ($roles) {
                    return in_array($user->roles()->first()?->id, $roles);
                });
            }
        }

        return $next($request);
    }
}
