<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CommissionImageSeeder extends Seeder
{
    public function run(): void
    {
        $commissions = DB::table('commissions')
            ->orderBy('id')
            ->get(['id', 'title']);

        if ($commissions->isEmpty()) {
            $this->command->warn('Aucune commission trouvée, exécutez CommissionSeeder avant.');
            return;
        }

        $imagesParTheme = [
            'portrait_personnage' => [
                "/La_Madone_de_São_Paulo_painting_by_Alexis_Diaz_and_INTI_in_São_Paulo_downtown.jpg",
                "/Arthur_Rackham,_untitled,_1904.jpg",
            ],
            'environnement_paysage' => [
                "/Paysage_-_Giovanni_Paolo_Panini_-_musée_d'art_et_d'histoire_de_Saint-Brieuc_-_DOC_12b.jpg",
                "/whyxing-chinese-painting-10006608_1920.png"
            ],
            'design_concept' => [
                "/lextotan-green-3140400.jpg",
                "/Arthur_Rackham,_untitled,_1904.jpg",
            ],
            'defaut' => [
                "/whyxing-chinese-painting-10006608_1920.png",
                "/La_Madone_de_São_Paulo_painting_by_Alexis_Diaz_and_INTI_in_São_Paulo_downtown.jpg",
            ]
        ];

        foreach ($commissions as $commission) {

            $titre = strtolower($commission->title);
            $themeChoisi = 'defaut';

            if (Str::contains($titre, ['portrait', 'character', 'personnage', 'mascotte', 'icône'])) {
                $themeChoisi = 'portrait_personnage';
            } elseif (Str::contains($titre, ['environnement', 'paysage', 'scène'])) {
                $themeChoisi = 'environnement_paysage';
            } elseif (Str::contains($titre, ['concept', 'croquis', 'lineart', 'design', 'emotes'])) {
                $themeChoisi = 'design_concept';
            }

            $poolImages = $imagesParTheme[$themeChoisi];

            $maxImages = min(3, count($poolImages));
            $nombreImages = rand(1, $maxImages);

            $imagesChoisies = Arr::random($poolImages, $nombreImages);

            foreach ($imagesChoisies as $index => $imagePath) {
                $variant = $index + 1;

                DB::table('commission_images')->insert([
                    'commission_id' => $commission->id,
                    'storage_path' => $imagePath,
                    'caption' => "{$commission->title} - aperçu {$variant}",
                    'created_at' => now()->subDays(25 - $variant),
                    'updated_at' => now()->subDays(8 - $variant),
                ]);
            }
        }
    }
}
