<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnswerSeeder extends Seeder
{
    /**
     * Réponses clients alignées avec les questions de la commission commandée.
     * Nécessite que OrderSeeder et QuestionSeeder aient déjà tourné.
     */
    public function run(): void
    {
        $orders = DB::table('orders')
            ->orderBy('id')
            ->get(['id', 'commission_id']);

        if ($orders->isEmpty()) {
            $this->command->warn('Commandes ou questions manquantes, exécutez OrderSeeder et QuestionSeeder avant.');
            return;
        }

        foreach ($orders as $orderIndex => $order) {
            $questions = DB::table('questions')
                ->where('commission_id', $order->commission_id)
                ->orderBy('id')
                ->get(['id', 'text', 'field_type']);

            foreach ($questions as $questionIndex => $question) {
                $questionText = json_decode($question->text, true) ?? [];
                $label = Str::lower($questionText['label'] ?? '');
                $options = $questionText['options'] ?? [];

                $value = match ($question->field_type) {
                    'text' => [
                        'text' => Str::contains($label, 'date')
                            ? now()->addDays(14 + $orderIndex)->toDateString()
                            : 'Commande orientée storytelling fantasy avec lumière chaude.',
                    ],
                    'number' => ['text' => (string) (($questionIndex % 3) + 1)],
                    'checkbox' => ['text' => $orderIndex % 2 === 0 ? 'Oui' : 'Non'],
                    'file' => [
                        'text' => "brief-ref-order-{$order->id}.png, moodboard-order-{$order->id}.jpg",
                        'files' => [
                            [
                                'url' => "/storage/order-files/brief-ref-order-{$order->id}.png",
                                'name' => "brief-ref-order-{$order->id}.png",
                            ],
                            [
                                'url' => "/storage/order-files/moodboard-order-{$order->id}.jpg",
                                'name' => "moodboard-order-{$order->id}.jpg",
                            ],
                        ],
                    ],
                    'select' => ['text' => $options[$orderIndex % max(count($options), 1)] ?? 'Standard'],
                    default => ['text' => 'Non renseigné'],
                };

                DB::table('answers')->insert([
                    'order_id' => $order->id,
                    'question_id' => $question->id,
                    'value' => json_encode($value, JSON_UNESCAPED_UNICODE),
                    'created_at' => now()->subDays(16 - $orderIndex),
                    'updated_at' => now()->subDays(8 - $orderIndex),
                ]);
            }
        }
    }
}
