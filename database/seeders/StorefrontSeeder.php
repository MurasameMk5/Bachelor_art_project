<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StorefrontSeeder extends Seeder
{
    /**
     * Un storefront par artiste.
     * Nécessite que UserSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $artists = DB::table('users')
            ->where('role', 'artist')
            ->orderBy('id')
            ->get(['id', 'name']);

        if ($artists->isEmpty()) {
            $this->command->warn('Aucun artiste trouvé, exécutez UserSeeder avant StorefrontSeeder.');
            return;
        }

        foreach ($artists as $artist) {
            $baseSlug = Str::slug($artist->name);

            DB::table('storefronts')->insert([
                'user_id' => $artist->id,
                'slug' => "{$baseSlug}-commissions",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
