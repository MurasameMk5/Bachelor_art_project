<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StorefrontSeeder extends Seeder
{
    /**
     * 10 storefronts, un par utilisateur ayant le rôle "artist".
     * Nécessite que UserSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $artistIds = DB::table('users')->where('role', 'artist')->pluck('id');

        if ($artistIds->isEmpty()) {
            $this->command->warn('Aucun artiste trouvé, exécutez UserSeeder avant StorefrontSeeder.');
            return;
        }

        for ($i = 1; $i <= $artistIds->count(); $i++) {
            DB::table('storefronts')->insert([
                'user_id' => $artistIds[$i % $artistIds->count()],
                'slug' => Str::slug("artist-storefront-$i") . '-' . Str::random(4),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
