<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentTableSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            [
                'name'              => 'School of Information Technology',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'School of Media Studies',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'School of Health Sciences',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'School of Nursing',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ]
        ];

        Department::insert($rows);
    }
}

