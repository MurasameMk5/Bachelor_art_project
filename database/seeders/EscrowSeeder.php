<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EscrowSeeder extends Seeder
{
    /**
     * 10 escrows, un par commande existante (dans la limite de 10 commandes).
     * Nécessite que OrderSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $orderIds = DB::table('orders')->pluck('id');

        if ($orderIds->isEmpty()) {
            $this->command->warn('Aucune commande trouvée, exécutez OrderSeeder avant EscrowSeeder.');
            return;
        }

        $fundsStatuses = ['pending', 'held', 'held', 'released', 'refunded', 'disputed'];

        for ($i = 1; $i <= 10; $i++) {
            $status = $fundsStatuses[$i % count($fundsStatuses)];

            DB::table('escrows')->insert([
                'order_id' => $orderIds[$i % $orderIds->count()],
                'stripe_payment_intent_id' => 'pi_' . Str::random(24),
                'funds_status' => $status,
                'held_at' => in_array($status, ['held', 'released', 'refunded', 'disputed']) ? now() : null,
                'released_at' => $status === 'released' ? now() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
