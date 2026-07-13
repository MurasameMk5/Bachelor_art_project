<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorefrontComponentSeeder extends Seeder
{
    /**
     * 10 composants répartis sur les storefronts existants.
     * Nécessite que StorefrontSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $storefrontIds = DB::table('storefronts')->pluck('id');

        if ($storefrontIds->isEmpty()) {
            $this->command->warn('Aucun storefront trouvé, exécutez StorefrontSeeder avant.');
            return;
        }

        $types = ['commission', 'text', 'image', 'kanban', 'divider'];

        $contentByType = [
            'commission' => fn () => ['commission_id' => rand(1, 10)],
            'text' => fn () => ['text' => 'Bienvenue sur ma vitrine, contactez-moi pour toute commande.'],
            'image' => fn () => ['image_ref' => '/images/sample.png', 'label' => 'Exemple de travail'],
            'kanban' => fn () => ['columns' => ['A faire', 'En cours', 'Terminé']],
            'divider' => fn () => [],
        ];

        for ($i = 1; $i <= 10; $i++) {
            $type = $types[$i % count($types)];

            DB::table('storefront_components')->insert([
                'storefront_id' => $storefrontIds[$i % $storefrontIds->count()],
                'type' => $type,
                'position' => $i,
                'content' => json_encode($contentByType[$type]()),
                'is_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
