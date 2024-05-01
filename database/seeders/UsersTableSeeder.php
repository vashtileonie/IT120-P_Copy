<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                => 1,
                'username'          => 'superadmin',
                'last_name'         => 'Administrator',
                'first_name'        => 'Mapua',
                'password'          => '$2y$10$zCFkT01MQCFKa0VMqQwmeOT84v5OFykkpGrYQTYJPufk74JwyvR5e', 
                'email'             => 'superadmin@mapua.com',
                'email_verified_at' => '2024-05-01 00:00:00',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ]
        ];

        //Default password is : PassAdmin1234*
        User::insert($users);
    }
}