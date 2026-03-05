<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = [];

        for ($i = 2020; $i <= 2030; $i++) {
            $years[] = [
                'year_name' => $i . '/' . ($i + 1),
                'start_date' => $i . '-07-01',
                'end_date' => ($i + 1) . '-06-30',
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('academic_years')->insert($years);
    }
}
