<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdvisingType;

class AdvisingTypeTableSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            [
                'name'              => 'Concerns about Electives/ Track in the Curriculum',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Concerns on Internship / OJT Matters',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Concerns regarding Placement / Employment Opportunities',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Concerns regarding Personal / Family',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Mentoring / Clarification on the Topic of the Subjects Enrolled',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Requirements in Course Enrolled',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Thesis/Design Subject concerns',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Others',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
        ];

        AdvisingType::insert($rows);
    }
}

