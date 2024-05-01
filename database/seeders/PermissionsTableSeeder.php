<?php
namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {

        $permissions = [];
        $prefixes = [
            'users', 'roles', 'permissions', 'advising_types', 'departments', 'form_types', 'priorities', 'subjects', 'positions',
            'employee_statuses', 'programs', 'employees', 'students', 'srequests', 'srequest_statuses'
        ];

        foreach($prefixes as $prefix){
            $permissions[] = [
                'name'         => $prefix.'_index',
                'created_at'   => '2024-05-01 00:00:00',
            ];
            $permissions[] = [
                'name'         => $prefix.'_create',
                'created_at'   => '2024-05-01 00:00:00',
            ];
            $permissions[] = [
                'name'         => $prefix.'_edit',
                'created_at'   => '2024-05-01 00:00:00',
            ];
            $permissions[] = [
                'name'         => $prefix.'_show',
                'created_at'   => '2024-05-01 00:00:00',
            ];
            $permissions[] = [
                'name'         => $prefix.'_delete',
                'created_at'   => '2024-05-01 00:00:00',
            ];
        }
        
        Permission::insert($permissions);
    }
}