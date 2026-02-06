<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = [
            [
            'name' => 'Greenwood High School',
            'slug' => 'greenwood-high-school',
            'address' => '123 Maple Street, Springfield',
            'phone' => '555-1234',
            'email' => 'info@greenwoodhighschool.edu',
            'status' => 'active',
            ],
            [
            'name' => 'Lakeside Academy',
            'slug' => 'lakeside-academy',
            'address' => '456 Oak Avenue, Lakeside',
            'phone' => '555-5678',
            'email' => 'info@lakesideacademy.edu',
            'status' => 'active',
            ],
            [
            'name' => 'Mountainview Institute',
            'slug' => 'mountainview-institute',
            'address' => '789 Pine Road, Mountainview',
            'phone' => '555-9012',
            'email' => 'info@mountainviewinstitute.edu',
            'status' => 'active',
            ],
        ];
        DB::table('schools')->insert($school);
    }
}
