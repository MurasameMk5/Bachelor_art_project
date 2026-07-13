<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * 10 questions réparties sur les commissions existantes.
     * Nécessite que CommissionSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $commissionIds = DB::table('commissions')->pluck('id');

        if ($commissionIds->isEmpty()) {
            $this->command->warn('Aucune commission trouvée, exécutez CommissionSeeder avant.');
            return;
        }

        $questions = [
            ['text' => 'Décrivez le personnage souhaité', 'field_type' => 'textarea'],
            ['text' => 'Nom du personnage', 'field_type' => 'text'],
            ['text' => 'Nombre de personnages', 'field_type' => 'number'],
            ['text' => 'Style souhaité', 'field_type' => 'select'],
            ['text' => 'Usage commercial ?', 'field_type' => 'checkbox'],
            ['text' => 'Référence visuelle (fichier)', 'field_type' => 'file'],
            ['text' => 'Palette de couleurs préférée', 'field_type' => 'text'],
            ['text' => 'Contexte / univers de la scène', 'field_type' => 'textarea'],
            ['text' => 'Budget maximum', 'field_type' => 'number'],
            ['text' => 'Délai souhaité', 'field_type' => 'text'],
        ];

        foreach ($questions as $i => $question) {
            DB::table('questions')->insert([
                'commission_id' => $commissionIds[$i % $commissionIds->count()],
                'text' => $question['text'],
                'field_type' => $question['field_type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
