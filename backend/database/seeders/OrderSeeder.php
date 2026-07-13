<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * 10 commandes reliant artistes, clients et commissions existants.
     * Nécessite que UserSeeder et CommissionSeeder aient déjà tourné.
     */
    public function run(): void
    {
        $artistIds = DB::table('users')->where('role', 'artist')->pluck('id');
        $clientIds = DB::table('users')->where('role', 'client')->pluck('id');
        $commissions = DB::table('commissions')->get();

        if ($artistIds->isEmpty() || $clientIds->isEmpty() || $commissions->isEmpty()) {
            $this->command->warn('Utilisateurs ou commissions manquants, exécutez UserSeeder et CommissionSeeder avant.');
            return;
        }

        $statuses = ['pending_payment', 'active', 'active', 'completed', 'cancelled', 'disputed'];
        $stages = ['brief', 'sketch', 'revision', 'final'];

        for ($i = 1; $i <= 10; $i++) {
            $commission = $commissions[$i % $commissions->count()];
            $basePrice = $commission->base_price;

            DB::table('orders')->insert([
                'artist_id' => $commission->artist_id,
                'client_id' => $clientIds[$i % $clientIds->count()],
                'commission_id' => $commission->id,
                'base_price' => $basePrice,
                'final_price' => $basePrice,
                'max_free_revisions' => $commission->max_free_revisions,
                'current_revision_count' => rand(0, $commission->max_free_revisions),
                'status' => $statuses[$i % count($statuses)],
                'production_stage' => $stages[$i % count($stages)],
                'invoice_number' => sprintf('INV-2026-%04d', $i),
                'invoice_generated_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
