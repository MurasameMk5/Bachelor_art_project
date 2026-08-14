<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Commandes réalistes liées aux commissions existantes.
     * Une commande par commission pour garantir la même volumétrie par artiste.
     * Nécessite que UserSeeder et CommissionSeeder aient déjà tourné.
     */
    public function run(): void
    {
        $clientIds = DB::table('users')
            ->where('role', 'client')
            ->orderBy('id')
            ->pluck('id');
        $commissions = DB::table('commissions')
            ->orderBy('id')
            ->get();

        if ($clientIds->isEmpty() || $commissions->isEmpty()) {
            $this->command->warn('Utilisateurs ou commissions manquants, exécutez UserSeeder et CommissionSeeder avant.');
            return;
        }

        $scenarios = [
            ['status' => 'to do', 'stage' => null, 'awaiting_confirmation' => false, 'revision_count' => 0, 'extra_price' => 0, 'stage_details' => null],
            [
                'status' => 'doing',
                'stage' => 'brief',
                'awaiting_confirmation' => false,
                'revision_count' => 0,
                'extra_price' => 0,
                'stage_details' => [
                    'brief' => [
                        'brief_html' => '<h2>Art commission brief</h2><p>Première synthèse du besoin client avec références visuelles.</p>',
                    ],
                ],
            ],
            [
                'status' => 'doing',
                'stage' => 'production',
                'awaiting_confirmation' => true,
                'revision_count' => 0,
                'extra_price' => 80,
                'stage_details' => [
                    'production' => [
                        'Sketch' => [
                            [
                                'url' => '/storage/order-images/sketch-01.webp',
                                'name' => 'sketch-01.webp',
                                'uploaded_at' => now()->subDays(2)->toDateTimeString(),
                            ],
                        ],
                        'Rendering' => [
                            [
                                'url' => '/storage/order-images/render-01.webp',
                                'name' => 'render-01.webp',
                                'uploaded_at' => now()->subDay()->toDateTimeString(),
                            ],
                        ],
                    ],
                ],
            ],
            [
                'status' => 'doing',
                'stage' => 'revision',
                'awaiting_confirmation' => true,
                'revision_count' => 1,
                'extra_price' => 120,
                'stage_details' => [
                    'revision' => [
                        [
                            'request' => 'Pouvez-vous renforcer le contraste sur le personnage principal et adoucir l arrière-plan ?',
                        ],
                    ],
                    'production' => [
                        'Inking' => [
                            [
                                'url' => '/storage/order-images/inking-01.webp',
                                'name' => 'inking-01.webp',
                                'uploaded_at' => now()->subDays(3)->toDateTimeString(),
                            ],
                        ],
                    ],
                ],
            ],
            [
                'status' => 'doing',
                'stage' => 'awaiting_payment',
                'awaiting_confirmation' => false,
                'revision_count' => 1,
                'extra_price' => 150,
                'stage_details' => [
                    'awaiting_payment' => [
                        'base' => null,
                    ],
                ],
            ],
            [
                'status' => 'done',
                'stage' => 'final_delivery',
                'awaiting_confirmation' => false,
                'revision_count' => 1,
                'extra_price' => 150,
                'stage_details' => [
                    'awaiting_payment' => [
                        'base' => 50,
                    ],
                ],
            ],
        ];

        foreach ($commissions as $index => $commission) {
            $scenario = $scenarios[$index % count($scenarios)];
            $basePrice = $commission->base_price;
            $revisionCount = min($scenario['revision_count'], $commission->max_free_revisions);
            $createdAt = now()->subDays(60 - ($index % 30));
            $invoiceGeneratedAt = $scenario['status'] === 'to do' ? null : $createdAt->copy()->addDay();

            DB::table('orders')->insert([
                'artist_id' => $commission->artist_id,
                'client_id' => $clientIds[$index % $clientIds->count()],
                'commission_id' => $commission->id,
                'base_price' => $basePrice,
                'final_price' => $basePrice + $scenario['extra_price'],
                'max_free_revisions' => $commission->max_free_revisions,
                'current_revision_count' => $revisionCount,
                'status' => $scenario['status'],
                'production_stage' => $scenario['stage'],
                'stage_details' => $scenario['stage_details'] !== null
                    ? json_encode($scenario['stage_details'], JSON_UNESCAPED_UNICODE)
                    : null,
                'awaiting_confirmation' => $scenario['awaiting_confirmation'],
                'invoice_number' => $scenario['status'] === 'to do' ? null : sprintf('INV-2026-%04d', $index + 1),
                'invoice_generated_at' => $invoiceGeneratedAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt->copy()->addDays(3),
            ]);
        }
    }
}
