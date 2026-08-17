<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorefrontComponentSeeder extends Seeder
{
    /**
     * Composants de storefront cohérents avec les commissions.
     * Nécessite que StorefrontSeeder ET CommissionSeeder aient déjà tourné.
     */
    public function run(): void
    {
        $storefronts = DB::table('storefronts')
            ->orderBy('id')
            ->get(['id', 'user_id']);
        $commissionsByArtist = DB::table('commissions')
            ->orderBy('id')
            ->get(['id', 'artist_id'])
            ->groupBy('artist_id');

        if ($storefronts->isEmpty()) {
            $this->command->warn('Aucun storefront trouvé, exécutez StorefrontSeeder avant.');
            return;
        }

        if ($commissionsByArtist->isEmpty()) {
            $this->command->warn('Aucune commission trouvée, exécutez CommissionSeeder avant.');
            return;
        }

        foreach ($storefronts as $storefront) {
            $position = 1;
            $components = [
                ['type' => 'text', 'content' => ['text' => "Welcome to my digital art studio! I specialize in fantasy character design, environment concept art, and detailed illustrations. I'm thrilled to help bring your ideas to life. I usually review commission requests and reply within 24-48 business hours. When submitting a request, please provide as many details and visual references as possible!"]],
                ['type' => 'image', 'content' => ['image_nb' => 1, 'images' => [['ref' => '/dillon-wanner-VdWI7XhTINg-unsplash.jpg', 'label' => 'Bannière atelier']]]],
                ['type' => 'tos', 'content' => ['text' => "Terms of Service:\n• Payment: A 50% non-refundable deposit is required upon approval of the initial rough sketch, with the remaining 50% due before the delivery of the final high-resolution files.\n• Process & Revisions: You will receive updates during the sketch and flat color stages. Up to 2 minor revisions are included for free. Major changes requested during the final rendering phase will incur additional fees.\n• Usage Rights: All commissioned pieces are for personal use only unless a commercial license is explicitly agreed upon and purchased. I retain the right to display the artwork in my professional portfolio and on my social media."]],
                ['type' => 'divider', 'content' => []],
            ];

            foreach ($components as $component) {
                DB::table('storefront_components')->insert([
                    'storefront_id' => $storefront->id,
                    'type' => $component['type'],
                    'position' => $position++,
                    'content' => json_encode($component['content'], JSON_UNESCAPED_UNICODE),
                    'is_visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($commissionsByArtist->get($storefront->user_id, collect()) as $commission) {
                $componentId = DB::table('storefront_components')->insertGetId([
                    'storefront_id' => $storefront->id,
                    'type' => 'commission',
                    'position' => $position++,
                    'content' => json_encode(['commission_id' => $commission->id]),
                    'is_visible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('commissions')
                    ->where('id', $commission->id)
                    ->update(['component_id' => $componentId]);
            }
        }
    }
}
