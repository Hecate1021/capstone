<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Default users
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'resort',
                'email' => 'resort@gmail.com',
                'password' => Hash::make('12345'),
                'role' => 'resort',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'resort1',
                'email' => 'resort1@gmail.com',
                'password' => Hash::make('12345'),
                'role' => 'resort',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Generate 30 random users
        for ($i = 0; $i < 30; $i++) {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('12345'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert users into the database
        DB::table('users')->insert($users);
    }
}
