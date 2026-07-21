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
        DB::table('users')->insert([
            'name' => "Aless",
            'email' => "alessand.neris@hes-so.ch",
            'password' => Hash::make('xillia27'),
            'role' => "artist",
        ]);
        DB::table('users')->insert([
            'name' => "Aleeeess",
            'email' => "aleess.neris@hes-so.ch",
            'password' => Hash::make('xillia27'),
            'role' => "client",
        ]);
    }
}
