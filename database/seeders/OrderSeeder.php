<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
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
                'stage_details' => [
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
