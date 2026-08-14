<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Questions de brief cohérentes pour chaque commission.
     * Nécessite que CommissionSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $commissions = DB::table('commissions')->orderBy('id')->get(['id']);

        if ($commissions->isEmpty()) {
            $this->command->warn('Aucune commission trouvée, exécutez CommissionSeeder avant.');
            return;
        }

        $questionTemplates = [
            ['text' => ['label' => 'Décrivez votre idée principale'], 'field_type' => 'text'],
            ['text' => ['label' => 'Ambiance recherchée (mots-clés)'], 'field_type' => 'text'],
            ['text' => ['label' => 'Nombre de personnages'], 'field_type' => 'number'],
            [
                'text' => [
                    'label' => 'Style visuel',
                    'options' => ['Semi-réaliste', 'Anime', 'Cartoon', 'Peinture numérique'],
                ],
                'field_type' => 'select'
            ],
            ['text' => ['label' => 'Usage commercial'], 'field_type' => 'checkbox'],
            ['text' => ['label' => 'Référence principale (fichier)'], 'field_type' => 'file'],
            ['text' => ['label' => 'Date de livraison souhaitée'], 'field_type' => 'text'],
            [
                'text' => [
                    'label' => 'Niveau de priorité',
                    'options' => ['Standard', 'Prioritaire'],
                ],
                'field_type' => 'select'
            ],
        ];

        foreach ($commissions as $commission) {
            foreach ($questionTemplates as $position => $question) {
                DB::table('questions')->insert([
                    'commission_id' => $commission->id,
                    'text' => json_encode($question['text'], JSON_UNESCAPED_UNICODE),
                    'field_type' => $question['field_type'],
                    'created_at' => now()->subDays(30 - $position),
                    'updated_at' => now()->subDays(10 - $position),
                ]);
            }
        }
    }
}