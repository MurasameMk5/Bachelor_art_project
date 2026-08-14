<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverableSeeder extends Seeder
{
    /**
     * Livrables cohérents avec l'avancement des commandes.
     * Nécessite que OrderSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $orders = DB::table('orders')
            ->orderBy('id')
            ->get(['id', 'status', 'current_revision_count', 'created_at']);

        if ($orders->isEmpty()) {
            $this->command->warn('Aucune commande trouvée, exécutez OrderSeeder avant DeliverableSeeder.');
            return;
        }

        foreach ($orders as $order) {
            $totalRevisions = max(1, $order->current_revision_count + 1);

            for ($revision = 1; $revision <= $totalRevisions; $revision++) {
                $status = match (true) {
                    $order->status === 'done' && $revision === $totalRevisions => 'approved',
                    $order->status === 'doing' && $revision === $totalRevisions => 'pending',
                    default => 'rejected',
                };

                DB::table('deliverables')->insert([
                    'order_id' => $order->id,
                    'private_storage_path' => "private/deliverables/order_{$order->id}/revision_{$revision}/artwork.png",
                    'revision_number' => $revision,
                    'status' => $status,
                    'created_at' => now()->subDays(12 - $revision),
                    'updated_at' => now()->subDays(4 - $revision),
                ]);
            }
        }
    }
}
