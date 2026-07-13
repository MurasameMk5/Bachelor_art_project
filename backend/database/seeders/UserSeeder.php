<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * 10 utilisateurs : 5 artistes, 5 clients.
     */
    public function run(): void
    {
        $roles = ['artist', 'client'];

        for ($i = 1; $i <= 10; $i++) {
            $role = $roles[$i % 2]; // alterne artist/client

            DB::table('users')->insert([
                'name' => "User $i " . ($role === 'artist' ? 'Artist' : 'Client'),
                'email' => "user{$i}@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => $role,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
