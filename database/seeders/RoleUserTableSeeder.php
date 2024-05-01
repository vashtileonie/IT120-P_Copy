<?php
namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        $role_user = [
            [
                'id'            => '1',
                'role_id'       => '1',
                'user_id'       => '1',
                'created_at'    => '2023-07-19 00:00:00',
            ]
        ];
        
        RoleUser::insert($role_user);
    }
}