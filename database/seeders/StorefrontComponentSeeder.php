<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorefrontComponentSeeder extends Seeder
{
    /**
     * Composants de storefront cohérents avec les commissions.
     * Nécessite que StorefrontSeeder ET CommissionSeeder aient déjà tourné.
     */
    public function run(): void
    {
        $storefronts = DB::table('storefronts')
            ->orderBy('id')
            ->get(['id', 'user_id']);
        $commissionsByArtist = DB::table('commissions')
            ->orderBy('id')
            ->get(['id', 'artist_id'])
            ->groupBy('artist_id');

        if ($storefronts->isEmpty()) {
            $this->command->warn('Aucun storefront trouvé, exécutez StorefrontSeeder avant.');
            return;
        }

        if ($commissionsByArtist->isEmpty()) {
            $this->command->warn('Aucune commission trouvée, exécutez CommissionSeeder avant.');
            return;
        }

        foreach ($storefronts as $storefront) {
            $position = 1;
            $components = [
                ['type' => 'text', 'content' => ['text' => 'Bienvenue sur mon atelier. Je réponds sous 24h les jours ouvrés.']],
                ['type' => 'image', 'content' => ['image_nb' => 1, 'images' => [['ref' => '/dillon-wanner-VdWI7XhTINg-unsplash.jpg', 'label' => 'Bannière atelier']]]],
                ['type' => 'tos', 'content' => ['text' => 'Paiement 50% à la validation du brief, 50% à la livraison finale.']],
                ['type' => 'divider', 'content' => []],
            ];

            foreach ($components as $component) {
                DB::table('storefront_components')->insert([
                    'storefront_id' => $storefront->id,
                    'type' => $component['type'],
                    'position' => $position++,
                    'content' => json_encode($component['content'], JSON_UNESCAPED_UNICODE),
                    'is_visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($commissionsByArtist->get($storefront->user_id, collect()) as $commission) {
                $componentId = DB::table('storefront_components')->insertGetId([
                    'storefront_id' => $storefront->id,
                    'type' => 'commission',
                    'position' => $position++,
                    'content' => json_encode(['commission_id' => $commission->id]),
                    'is_visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('commissions')
                    ->where('id', $commission->id)
                    ->update(['component_id' => $componentId]);
            }
        }
    }
}
