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
            'name' => 'Super Admin',
            ],
            [
            'name' => 'School Admin',
            ],
            [
            'name' => 'Teacher',
            ],
            [
            'name' => 'Student',
            ]
        ];
        DB::table('roles')->insert($roles);
    }
}
