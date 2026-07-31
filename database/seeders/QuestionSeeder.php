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

        // On structure 'text' comme un tableau avec au minimum un 'label'
        // Et des 'options' si c'est un type 'select' ou 'radio'
        $questions = [
            ['text' => ['label' => 'Décrivez le personnage souhaité'], 'field_type' => 'text'],
            ['text' => ['label' => 'Nom du personnage'], 'field_type' => 'text'],
            ['text' => ['label' => 'Nombre de personnages'], 'field_type' => 'number'],
            [
                'text' => [
                    'label' => 'Style souhaité', 
                    'options' => ['Anime', 'Réaliste', 'Cartoon', 'Pixel Art'] // <-- Options ajoutées ici
                ], 
                'field_type' => 'select'
            ],
            ['text' => ['label' => 'Usage commercial ?'], 'field_type' => 'checkbox'],
            ['text' => ['label' => 'Référence visuelle (fichier)'], 'field_type' => 'file'],
            ['text' => ['label' => 'Palette de couleurs préférée'], 'field_type' => 'text'],
            ['text' => ['label' => 'Contexte / univers de la scène'], 'field_type' => 'text'],
            ['text' => ['label' => 'Budget maximum'], 'field_type' => 'number'],
            [
                'text' => [
                    'label' => 'Délai souhaité',
                    'options' => ['Pas d\'urgence', 'Moins d\'un mois', 'Moins d\'une semaine']
                ], 
                'field_type' => 'select' // J'ai transformé celui-ci en select pour l'exemple
            ],
        ];

        foreach ($questions as $i => $question) {
            DB::table('questions')->insert([
                'commission_id' => $commissionIds[$i % $commissionIds->count()],
                // On utilise json_encode car DB::table bypass les casts du Modèle
                'text' => json_encode($question['text'], JSON_UNESCAPED_UNICODE),
                'field_type' => $question['field_type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}