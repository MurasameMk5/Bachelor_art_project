<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionSeeder extends Seeder
{
    /**
     * Commissions réalistes associées aux artistes.
     * Nécessite que UserSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $artistIds = DB::table('users')
            ->where('role', 'artist')
            ->orderBy('id')
            ->pluck('id');

        if ($artistIds->isEmpty()) {
            $this->command->warn('Aucun artiste trouvé, exécutez UserSeeder avant CommissionSeeder.');
            return;
        }

        $catalog = [
            ['title' => 'Portrait éditorial couleur', 'description' => 'Portrait semi-réaliste, fond simple, usage web éditorial.', 'base_price' => 320, 'estimated_days' => 7, 'max_free_revisions' => 1, 'status' => 'open', 'slots_available' => 3],
            ['title' => 'Character design complet', 'description' => 'Fiche personnage avec face, profil et palette.', 'base_price' => 780, 'estimated_days' => 14, 'max_free_revisions' => 2, 'status' => 'open', 'slots_available' => 2],
            ['title' => 'Illustration couverture roman', 'description' => 'Composition complète pour couverture print et numérique.', 'base_price' => 1200, 'estimated_days' => 20, 'max_free_revisions' => 2, 'status' => 'paused', 'slots_available' => 1],
            ['title' => 'Pack emotes stream x6', 'description' => 'Six emotes cohérentes prêtes pour Twitch/Discord.', 'base_price' => 260, 'estimated_days' => 5, 'max_free_revisions' => 1, 'status' => 'open', 'slots_available' => 4],
            ['title' => 'Concept environnement', 'description' => 'Key art d environnement pour jeu indépendant.', 'base_price' => 980, 'estimated_days' => 16, 'max_free_revisions' => 2, 'status' => 'open', 'slots_available' => 2],
            ['title' => 'Portrait duo stylisé', 'description' => 'Deux personnages en plan taille, rendu painterly.', 'base_price' => 540, 'estimated_days' => 9, 'max_free_revisions' => 1, 'status' => 'closed', 'slots_available' => 0],
            ['title' => 'Icône profil premium', 'description' => 'Avatar carré optimisé réseaux sociaux.', 'base_price' => 140, 'estimated_days' => 3, 'max_free_revisions' => 1, 'status' => 'open', 'slots_available' => 6],
            ['title' => 'Splash art action', 'description' => 'Illustration dynamique avec effets de lumière.', 'base_price' => 890, 'estimated_days' => 15, 'max_free_revisions' => 2, 'status' => 'open', 'slots_available' => 2],
            ['title' => 'Croquis exploratoires x10', 'description' => 'Batch de recherches visuelles noir et blanc.', 'base_price' => 300, 'estimated_days' => 6, 'max_free_revisions' => 0, 'status' => 'open', 'slots_available' => 5],
            ['title' => 'Illustration de scène narrative', 'description' => 'Scène détaillée pour campagne marketing.', 'base_price' => 1350, 'estimated_days' => 24, 'max_free_revisions' => 3, 'status' => 'paused', 'slots_available' => 1],
            ['title' => 'Mascotte de marque', 'description' => 'Création de mascotte avec variation expression.', 'base_price' => 690, 'estimated_days' => 12, 'max_free_revisions' => 2, 'status' => 'open', 'slots_available' => 2],
            ['title' => 'Lineart personnage', 'description' => 'Lineart propre prêt à colorisation.', 'base_price' => 210, 'estimated_days' => 4, 'max_free_revisions' => 1, 'status' => 'open', 'slots_available' => 4],
        ];

        foreach ($artistIds as $artistIndex => $artistId) {
            foreach ($catalog as $commissionIndex => $commission) {
                $daysOffset = ($commissionIndex * 2) + ($artistIndex % 3);

                DB::table('commissions')->insert([
                    'artist_id' => $artistId,
                    'component_id' => null,
                    'title' => $commission['title'],
                    'description' => $commission['description'],
                    'base_price' => $commission['base_price'],
                    'currency' => 'CHF',
                    'estimated_days' => $commission['estimated_days'],
                    'max_free_revisions' => $commission['max_free_revisions'],
                    'status' => $commission['status'],
                    'slots_available' => $commission['slots_available'],
                    'created_at' => now()->subDays(45 - $daysOffset),
                    'updated_at' => now()->subDays(20 - ($commissionIndex % 8)),
                ]);
            }
        }
    }
}