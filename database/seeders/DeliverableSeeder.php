<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverableSeeder extends Seeder
{
    /**
     * 10 livrables répartis sur les commandes existantes.
     * Nécessite que OrderSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $orderIds = DB::table('orders')->pluck('id');

        if ($orderIds->isEmpty()) {
            $this->command->warn('Aucune commande trouvée, exécutez OrderSeeder avant DeliverableSeeder.');
            return;
        }

        $statuses = ['pending', 'approved', 'approved', 'rejected'];

        for ($i = 1; $i <= 10; $i++) {
            DB::table('deliverables')->insert([
                'order_id' => $orderIds[$i % $orderIds->count()],
                'private_storage_path' => "private/deliverables/order_{$i}/revision_1/final.png",
                'revision_number' => rand(1, 3),
                'status' => $statuses[$i % count($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
