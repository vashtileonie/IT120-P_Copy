<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;

class PriorityTableSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            [
                'name'              => 'Low',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Moderate',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'High',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ]
        ];

        Priority::insert($rows);
    }
}

