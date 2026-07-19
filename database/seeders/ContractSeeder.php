<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    /**
     * 10 contrats, un par commande existante (dans la limite de 10 commandes).
     * Nécessite que OrderSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $orderIds = DB::table('orders')->pluck('id');

        if ($orderIds->isEmpty()) {
            $this->command->warn('Aucune commande trouvée, exécutez OrderSeeder avant ContractSeeder.');
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            DB::table('contracts')->insert([
                'order_id' => $orderIds[$i % $orderIds->count()],
                'unique_reference' => sprintf('CTR-2026-%04d', $i),
                'answers_snapshot' => json_encode([
                    'snapshot_taken_at' => now()->toDateTimeString(),
                    'answers' => ["Réponse figée #$i"],
                ]),
                'signed_at' => $i % 3 === 0 ? null : now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
