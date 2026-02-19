<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Super Admin',
        //     'email' => 'superadmin@edunest.com',
        //     'password' => bcrypt('password'),
        //     'role_id' => 1,
        //     'school_id' => 1,
        // ]);

        $user = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@edunest.com',
                'password' => bcrypt('password'),
                'role_id' => 1,
                'school_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'School Admin',
                'email' => 'schooladmin@edunest.com',
                'password' => bcrypt('password'),
                'role_id' => 2,
                'school_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teacher User',
                'email' => 'teacher@edunest.com',
                'password' => bcrypt('password'),
                'role_id' => 3,
                'school_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            // ,
            // [
            //     'name' => 'Student User',
            //     'email' => 'student@edunest.com',
            //     'password' => bcrypt('password'),
            //     'role_id' => 4,
            //     'school_id' => 2,
            // ]
        ];
        User::insert($user);
        $students = [];

        for ($i = 1; $i <= 30; $i++) {
            $students[] = [
                'name' => 'Student User ' . $i,
                'email' => 'student' . $i . '@edunest.com',
                'password' => bcrypt('password'),
                'role_id' => 4,
                'school_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        User::insert($students);
        
    }
}
