<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([

            // admin
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@pembo.org',
                'password' => Hash::make('1234567890'),
                'role' => 'admin',
                'status' => 'active'
            ],

            // agent
            [
                'name' => 'Agent',
                'username' => 'agent',
                'email' => 'agent@pembo.org',
                'password' => Hash::make('1234567890'),
                'role' => 'agent',
                'status' => 'active'
            ],
            // user
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@pembo.org',
                'password' => Hash::make('1234567890'),
                'role' => 'user',
                'status' => 'active'
            ]
        ]);

    }
}
