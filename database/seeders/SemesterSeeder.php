<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = DB::table('academic_years')->get();

        $semesters = [];

        foreach ($academicYears as $year) {

            // Semester 1
            $semesters[] = [
                'academic_year_id' => $year->academic_year_id,
                'semester_name' => 'Semester 1',
                'start_date' => $year->start_date,
                'end_date' => date('Y-m-d', strtotime('+5 months', strtotime($year->start_date))),
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Semester 2
            $semesters[] = [
                'academic_year_id' => $year->academic_year_id,
                'semester_name' => 'Semester 2',
                'start_date' => date('Y-m-d', strtotime('+6 months', strtotime($year->start_date))),
                'end_date' => $year->end_date,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('semesters')->insert($semesters);
    }
}
