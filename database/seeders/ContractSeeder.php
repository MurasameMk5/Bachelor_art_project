<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    /**
     * Contrats générés à partir des réponses réelles des commandes.
     * Nécessite que OrderSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $orders = DB::table('orders')
            ->orderBy('id')
            ->get(['id', 'status', 'created_at']);

        if ($orders->isEmpty()) {
            $this->command->warn('Aucune commande trouvée, exécutez OrderSeeder avant ContractSeeder.');
            return;
        }

        foreach ($orders as $order) {
            $answers = DB::table('answers')
                ->join('questions', 'questions.id', '=', 'answers.question_id')
                ->where('answers.order_id', $order->id)
                ->orderBy('answers.id')
                ->get(['questions.text', 'answers.value'])
                ->map(function ($item) {
                    $question = json_decode($item->text, true) ?? [];
                    return [
                        'question' => $question['label'] ?? 'Question',
                        'answer' => json_decode($item->value, true),
                    ];
                })
                ->values();

            DB::table('contracts')->insert([
                'order_id' => $order->id,
                'unique_reference' => sprintf('CTR-2026-%04d', $order->id),
                'answers_snapshot' => json_encode([
                    'snapshot_taken_at' => now()->toDateTimeString(),
                    'answers' => $answers,
                ], JSON_UNESCAPED_UNICODE),
                'signed_at' => $order->status === 'to do' ? null : now()->subDays(7),
                'created_at' => $order->created_at,
                'updated_at' => now()->subDays(2),
            ]);
        }
    }
}
