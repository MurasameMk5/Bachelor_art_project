<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswerSeeder extends Seeder
{
    /**
     * 10 réponses reliant commandes et questions existantes.
     * Nécessite que OrderSeeder et QuestionSeeder aient déjà tourné.
     */
    public function run(): void
    {
        $orderIds = DB::table('orders')->pluck('id');
        $questionIds = DB::table('questions')->pluck('id');

        if ($orderIds->isEmpty() || $questionIds->isEmpty()) {
            $this->command->warn('Commandes ou questions manquantes, exécutez OrderSeeder et QuestionSeeder avant.');
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            DB::table('answers')->insert([
                'order_id' => $orderIds[$i % $orderIds->count()],
                'question_id' => $questionIds[$i % $questionIds->count()],
                'value' => json_encode(['text' => "Réponse du client pour la question #$i"]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
