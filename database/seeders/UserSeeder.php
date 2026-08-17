<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Utilisateurs réalistes pour tests métier.
     */
    public function run(): void
    {
        $password = Hash::make('atelier123');
        $now = now();

        $artists = [
            ['name' => 'Aless', 'email' => 'aless@atelier.test'],
            ['name' => 'Michelangelo', 'email' => 'michelangelo@atelier.test'],
            ['name' => 'Monet', 'email' => 'monet@atelier.test'],
            ['name' => 'Rubens', 'email' => 'rubens@atelier.test'],
        ];

        $clients = [
            ['name' => 'Elio Dubois', 'email' => 'elio.dubois@client.test'],
            ['name' => 'Maya Roch', 'email' => 'maya.roch@client.test'],
            ['name' => 'Theo Bianchi', 'email' => 'theo.bianchi@client.test'],
            ['name' => 'Camille Jordan', 'email' => 'camille.jordan@client.test'],
            ['name' => 'Noah Meyer', 'email' => 'noah.meyer@client.test'],
            ['name' => 'Lea Kuster', 'email' => 'lea.kuster@client.test'],
            ['name' => 'Eva Gross', 'email' => 'eva.gross@client.test'],
            ['name' => 'Milo Gerber', 'email' => 'milo.gerber@client.test'],
        ];

        $rows = [];

        foreach ($artists as $artist) {
            $rows[] = [
                'name' => $artist['name'],
                'email' => $artist['email'],
                'email_verified_at' => $now,
                'password' => $password,
                'role' => 'artist',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach ($clients as $client) {
            $rows[] = [
                'name' => $client['name'],
                'email' => $client['email'],
                'email_verified_at' => $now,
                'password' => $password,
                'role' => 'client',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('users')->insert($rows);
    }
}
