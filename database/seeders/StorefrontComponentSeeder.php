<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorefrontComponentSeeder extends Seeder
{
    /**
     * 10 composants répartis sur les storefronts existants.
     * Nécessite que StorefrontSeeder ET CommissionSeeder aient déjà tourné.
     */
    public function run(): void
    {
        $storefrontIds = DB::table('storefronts')->pluck('id');
        $commissionIds = DB::table('commissions')->pluck('id');

        if ($storefrontIds->isEmpty()) {
            $this->command->warn('Aucun storefront trouvé, exécutez StorefrontSeeder avant.');
            return;
        }

        if ($commissionIds->isEmpty()) {
            $this->command->warn('Aucune commission trouvée, exécutez CommissionSeeder avant.');
            return;
        }

        $types = ['commission', 'text', 'image', 'kanban', 'divider'];
        $commissionIndex = 0;

        for ($i = 1; $i <= 10; $i++) {
            $type = $types[$i % count($types)];
            $content = [];

            // Si c't un composant commission, on prend une vraie commission dispo
            $assignedCommissionId = null;
            if ($type === 'commission') {
                $assignedCommissionId = $commissionIds[$commissionIndex % $commissionIds->count()];
                $content = ['commission_id' => $assignedCommissionId];
                $commissionIndex++;
            } else {
                $content = match ($type) {
                    'text' => ['text' => 'Bienvenue sur ma vitrine, contactez-moi pour toute commande.'],
                    'image' => ['images' => [['ref' => '/Akihiko Yoshida-min.png', 'label' => 'Exemple de travail']]],
                    'kanban' => ['columns' => ['A faire', 'En cours', 'Terminé']],
                    'divider' => [],
                    default => [],
                };
            }

            // Insertion du composant
            $componentId = DB::table('storefront_components')->insertGetId([
                'storefront_id' => $storefrontIds[$i % $storefrontIds->count()],
                'type' => $type,
                'position' => $i,
                'content' => json_encode($content),
                'is_visible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Si c'est un composant commission, on met à jour le component_id dans la table commissions
            if ($assignedCommissionId) {
                DB::table('commissions')
                    ->where('id', $assignedCommissionId)
                    ->update(['component_id' => $componentId]);
            }
        }
    }
}