<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function(){ 

    Route::get('/', 'Admin\HomeController@index')->name('login');
    //Route::get('/profile', 'Admin\UsersController@profile')->name('users.profile');

    Route::group(['namespace' => 'Auth', 'middleware' => ['guest']], function() {
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
    });

    Route::group(['namespace' => 'Admin', 'middleware' => ['web','auth','auth.session']], function() {
        Route::resources([
            'dashboard'         => DashboardController::class,
            'advising-types'    => AdvisingTypesController::class,
            'users'             => UsersController::class,
            'roles'             => RolesController::class,
            'permissions'       => PermissionsController::class,
            'departments'       => DepartmentsController::class,
            'form-types'        => FormTypesController::class,
            'priorities'        => PrioritiesController::class,
            'subjects'          => SubjectsController::class,
            'positions'         => PositionsController::class,
            'employee-statuses' => EmployeeStatusesController::class,
            'programs'          => ProgramsController::class,
            /*'audit-logs'      => AuditLogsController::class,*/
        ]);

        Route::get('/roles/permissions/{role}', 'RolesController@rolePermissions')->name('roles.permissions');
        Route::get('/permissions/roles/{permission}', 'PermissionsController@permissionRoles')->name('permissions.roles');
        Route::put('/users/update-credentials/{user}', 'UsersController@updateCredentials')->name('users.update-credentials');
    });

    Route::group(['namespace' => 'Auth', 'middleware' => ['web','auth']], function() {
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});