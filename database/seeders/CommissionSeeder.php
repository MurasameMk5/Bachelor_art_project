<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionSeeder extends Seeder
{
    /**
     * 10 commissions réparties sur les artistes existants.
     * Nécessite que UserSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $artistIds = DB::table('users')->where('role', 'artist')->pluck('id');

        if ($artistIds->isEmpty()) {
            $this->command->warn('Aucun artiste trouvé, exécutez UserSeeder avant CommissionSeeder.');
            return;
        }

        $titles = [
            'Portrait couleur', 'Character design', 'Illustration pleine page',
            'Chibi simple', 'Concept art', 'Portrait duo', 'Icone profil',
            'Illustration environnement', 'Croquis rapide', 'Illustration complète',
        ];

        $statuses = ['open', 'open', 'open', 'paused', 'closed'];

        for ($i = 1; $i <= 10; $i++) {
            DB::table('commissions')->insert([
                'artist_id' => $artistIds[$i % $artistIds->count()],
                'component_id' => null, // Sera lié lors de la création du composant
                'title' => $titles[$i - 1],
                'description' => "Description détaillée de la commission : {$titles[$i - 1]}.",
                'base_price' => rand(20, 200) * 10,
                'currency' => 'CHF',
                'estimated_days' => rand(3, 21),
                'max_free_revisions' => rand(0, 3),
                'status' => $statuses[$i % count($statuses)],
                'slots_available' => rand(0, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}