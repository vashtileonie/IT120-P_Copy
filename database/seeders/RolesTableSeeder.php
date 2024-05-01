<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'                => 1,
                'name'              => 'Super Administrator',
                'created_at'        => '2023-07-19 00:00:00',
                'updated_at'        => '2023-07-19 00:00:00'
            ],
            [
                'id'                => 2,
                'name'              => 'Administration',
                'created_at'        => '2023-07-19 00:00:00',
                'updated_at'        => '2023-07-19 00:00:00'
            ],
            [
                'id'                => 3,
                'name'              => 'Professor',
                'created_at'        => '2023-07-19 00:00:00',
                'updated_at'        => '2023-07-19 00:00:00'
            ],
            [
                'id'                => 4,
                'name'              => 'Student',
                'created_at'        => '2023-07-19 00:00:00',
                'updated_at'        => '2023-07-19 00:00:00'
            ]
        ];

        Role::insert($roles);
    }
}

