<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $roles = [
            [
            'name' => 'super_admin',
            ],
            [
            'name' => 'school_admin',
            ],
            [
            'name' => 'teacher',
            ],
            [
            'name' => 'Student',
            ]
        ];
        DB::table('roles')->insert($roles);
    }
}
