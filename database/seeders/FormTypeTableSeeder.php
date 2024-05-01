<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormType;

class FormTypeTableSeeder extends Seeder
{
    public function run()
    {
        $rows = [
            [
                'name'              => 'Peer Advising at W501-Intramuros/ R203-Makati',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Career Advising at Center for Career Services',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ],
            [
                'name'              => 'Counseling of Personal Concerns at Center for Guidance and Counseling',
                'created_at'        => '2024-05-01 00:00:00',
                'updated_at'        => '2024-05-01 00:00:00'
            ]
        ];

        FormType::insert($rows);
    }
}

