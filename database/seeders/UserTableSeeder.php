<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate(); // Clear data to avoid duplicates.
        // Beheerder user
        DB::table('users')->insert([
            'name' => 'Beheerder',
            'email' => 'beheerder@technova.nl',
            'password' => Hash::make('beheerder'),
            'role' => 'admin'
        ]);
        // Moderator user
        DB::table('users')->insert([
            'name' => 'Moderator',
            'email' => 'moderator@technova.nl',
            'password' => Hash::make('moderator'),
            'role' => 'moderator'
        ]);
        // Gebruiker user
        DB::table('users')->insert([
            'name' => 'Gebruiker',
            'email' => 'gebruiker@technova.nl',
            'password' => Hash::make('gebruiker'),
            'role' => 'user'
        ]);
    }
}
