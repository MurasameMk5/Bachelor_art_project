<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $artistIds = DB::table('users')
            ->where('role', 'artist')
            ->orderBy('id')
            ->pluck('id');

        $clientIds = DB::table('users')
            ->where('role', 'client')
            ->orderBy('id')
            ->pluck('id');

        // On récupère toutes les commissions, groupées par artiste
        $commissionsByArtist = DB::table('commissions')
            ->get()
            ->groupBy('artist_id');

        if ($artistIds->isEmpty() || $clientIds->isEmpty() || $commissionsByArtist->isEmpty()) {
            $this->command->warn('Missing users or commissions. Please run UserSeeder and CommissionSeeder first.');
            return;
        }

        $scenarios = [
            [
                'status' => 'to do',
                'stage' => null,
                'awaiting_confirmation' => false,
                'revision_count' => 0,
                'extra_price' => 0,
                'stage_details' => null
            ],
            [
                'status' => 'doing',
                'stage' => 'brief',
                'awaiting_confirmation' => false,
                'revision_count' => 0,
                'extra_price' => 0,
                'stage_details' => [],
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
                                'url' => '/whyxing-chinese-painting-10006608_1920.png',
                                'name' => 'initial_rough_sketch_v1.png',
                                'uploaded_at' => now()->subDays(2)->toDateTimeString(),
                            ],
                        ],
                        'Rendering' => [
                            [
                                'url' => '/Arthur_Rackham,_untitled,_1904.jpg',
                                'name' => 'color_blocking_preview.jpg',
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
                            'request' => 'Could you increase the contrast on the main character to make them pop out more? Also, please soften the background a bit so it doesn\'t distract from the face. Thank you!',
                        ],
                    ],
                    'production' => [
                        'Inking' => [
                            [
                                'url' => '/Arthur_Rackham,_untitled,_1904.jpg',
                                'name' => 'updated_inking_v2.jpg',
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
                        'pending_amount' => 150,
                        'message' => 'The artwork is complete! Please proceed with the final payment to unlock the high-resolution files.',
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
                    'final_delivery' => [
                        'message' => 'Thank you for your trust! Here are the final files for your commission.',
                        'files' => [
                            [
                                'url' => '/La_Madone_de_São_Paulo_painting_by_Alexis_Diaz_and_INTI_in_São_Paulo_downtown.jpg',
                                'name' => 'artwork_final_highres.jpg',
                                'uploaded_at' => now()->toDateTimeString(),
                            ]
                        ]
                    ],
                ],
            ],
        ];

        $ordersToInsert = [];
        $orderIndex = 0;

        // 💡 1. On boucle sur CHAQUE artiste cette fois
        foreach ($artistIds as $artistId) {

            // On vérifie que l'artiste a bien des commissions (sinon on le passe)
            $artistCommissions = $commissionsByArtist->get($artistId);
            if (!$artistCommissions || $artistCommissions->isEmpty()) {
                continue;
            }

            // 💡 2. Pour chaque artiste, on boucle sur CHAQUE scénario
            foreach ($scenarios as $scenario) {

                // On pioche une commission APPARTENANT à cet artiste
                $commission = $artistCommissions[$orderIndex % $artistCommissions->count()];
                $basePrice = $commission->base_price;

                // On attribue un client à tour de rôle
                $clientId = $clientIds[$orderIndex % $clientIds->count()];

                $revisionCount = min($scenario['revision_count'], $commission->max_free_revisions);

                $createdAt = now()->subDays(60 - ($orderIndex % 30));
                $invoiceGeneratedAt = $scenario['status'] === 'to do' ? null : $createdAt->copy()->addDay();

                $ordersToInsert[] = [
                    'artist_id' => $artistId, // Forcément l'artiste actuel
                    'client_id' => $clientId, // Client rotatif
                    'commission_id' => $commission->id, // Commission de cet artiste
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
                    'invoice_number' => $scenario['status'] === 'to do' ? null : sprintf('INV-2026-%04d', $orderIndex + 1),
                    'invoice_generated_at' => $invoiceGeneratedAt,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt->copy()->addDays(3),
                ];

                $orderIndex++;
            }
        }

        DB::table('orders')->insert($ordersToInsert);
    }
}
