<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'subject_name' => 'Mathematics',
                'school_id' => 2,
            ],
            [
                'subject_name' => 'Science',
                'school_id' => 2,
            ],
            [
                'subject_name' => 'History',
                'school_id' => 2,
            ],
            [
                'subject_name' => 'English',
                'school_id' => 2,
            ],
        ];
        Subject::insert($subjects);
    }
}
