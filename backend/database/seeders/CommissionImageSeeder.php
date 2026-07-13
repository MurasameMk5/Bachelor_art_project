<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionImageSeeder extends Seeder
{
    /**
     * 10 images d'exemple réparties sur les commissions existantes.
     * Nécessite que CommissionSeeder ait déjà tourné.
     *
     * Note : la table réellement créée par la migration est "commission_image"
     * (singulier) — le down() de la migration référence "commission_images"
     * (pluriel), ce qui est incohérent. A corriger dans la migration.
     */
    public function run(): void
    {
        $commissionIds = DB::table('commissions')->pluck('id');

        if ($commissionIds->isEmpty()) {
            $this->command->warn('Aucune commission trouvée, exécutez CommissionSeeder avant.');
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            DB::table('commission_images')->insert([
                'commission_id' => $commissionIds[$i % $commissionIds->count()],
                'storage_path' => "public/commissions/example-$i.png",
                'caption' => "Exemple de travail #$i",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
