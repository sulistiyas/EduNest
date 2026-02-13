<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class = [
            [
                'name' => 'Class 1',
                'school_id' => 2,
            ],
            [
                'name' => 'Class 2',
                'school_id' => 2,
            ],
            [
                'name' => 'Class 3',
                'school_id' => 2,
            ],
        ];
        Classes::insert($class);
    }
}
