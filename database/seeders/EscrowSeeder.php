<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscrowSeeder extends Seeder
{
    /**
     * Escrows cohérents avec l'état réel des commandes.
     * Nécessite que OrderSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $orders = DB::table('orders')
            ->orderBy('id')
            ->get(['id', 'status', 'created_at']);

        if ($orders->isEmpty()) {
            $this->command->warn('Aucune commande trouvée, exécutez OrderSeeder avant EscrowSeeder.');
            return;
        }

        foreach ($orders as $order) {
            $status = match ($order->status) {
                'to do' => 'pending',
                'doing' => 'held',
                'done' => 'released',
                'cancelled' => 'refunded',
                default => 'pending',
            };
            $heldAt = in_array($status, ['held', 'released', 'refunded'], true)
                ? $order->created_at
                : null;

            DB::table('escrows')->insert([
                'order_id' => $order->id,
                'stripe_payment_intent_id' => 'pi_seed_' . sprintf('%012d', $order->id),
                'funds_status' => $status,
                'held_at' => $heldAt,
                'released_at' => $status === 'released' ? now()->subDays(1) : null,
                'created_at' => $order->created_at,
                'updated_at' => now(),
            ]);
        }
    }
}
