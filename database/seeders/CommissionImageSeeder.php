<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionImageSeeder extends Seeder
{
    /**
     * Images de portfolio liées aux commissions.
     * Nécessite que CommissionSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $commissions = DB::table('commissions')
            ->orderBy('id')
            ->get(['id', 'title']);

        if ($commissions->isEmpty()) {
            $this->command->warn('Aucune commission trouvée, exécutez CommissionSeeder avant.');
            return;
        }

        foreach ($commissions as $commission) {
            for ($variant = 1; $variant <= 2; $variant++) {
                DB::table('commission_images')->insert([
                    'commission_id' => $commission->id,
                    'storage_path' => "/samples/commissions/{$commission->id}/preview-{$variant}.webp",
                    'caption' => "{$commission->title} - aperçu {$variant}",
                    'created_at' => now()->subDays(25 - $variant),
                    'updated_at' => now()->subDays(8 - $variant),
                ]);
            }
        }
    }
}
