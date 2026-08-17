<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionSeeder extends Seeder
{
    public function run(): void
    {
        $artistIds = DB::table('users')
            ->where('role', 'artist')
            ->orderBy('id')
            ->pluck('id');

        if ($artistIds->isEmpty()) {
            $this->command->warn('No artists found. Please run UserSeeder before CommissionSeeder.');
            return;
        }

        $catalog = [
            [
                'title' => 'Editorial Color Portrait',
                'description' => 'Semi-realistic portrait from the chest up with a simple or solid color background. Ideal for editorial use, professional web profiles, or personal branding. You will receive a high-resolution file (300dpi) ready for print and web. Please provide clear reference photos and specify your preferred color palette.',
                'base_price' => 320, 'estimated_days' => 7, 'max_free_revisions' => 1, 'status' => 'open', 'slots_available' => 3
            ],
            [
                'title' => 'Full Character Design Sheet',
                'description' => 'A comprehensive character reference sheet including one full-body front view, a side or back view, three facial expressions, and a detailed color palette. Perfect for VTubers, D&D characters, or game development. Includes a transparent PNG version. I need a detailed written description or moodboard to start.',
                'base_price' => 780, 'estimated_days' => 14, 'max_free_revisions' => 2, 'status' => 'open', 'slots_available' => 2
            ],
            [
                'title' => 'Book Cover Illustration',
                'description' => 'Full-scale, highly detailed illustration tailored for print and digital book covers (wrap-around if needed). This includes typography placement consultation. The final delivery will be CMYK print-ready and RGB digital formats. Please provide a synopsis, main character details, and the desired mood/atmosphere.',
                'base_price' => 1200, 'estimated_days' => 20, 'max_free_revisions' => 2, 'status' => 'paused', 'slots_available' => 1
            ],
            [
                'title' => 'Twitch/Discord Emote Pack (x6)',
                'description' => 'A bundle of 6 custom, highly expressive emotes optimized for Twitch and Discord. You will receive each emote in standard sizes (112px, 56px, 28px) plus a 500px high-res bonus file. Cute, chibi, or stylized according to your brand. Tell me the specific expressions you need (e.g., hype, cry, rage).',
                'base_price' => 260, 'estimated_days' => 5, 'max_free_revisions' => 1, 'status' => 'open', 'slots_available' => 4
            ],
        ];

        foreach ($artistIds as $artistIndex => $artistId) {
            foreach ($catalog as $commissionIndex => $commission) {
                $daysOffset = ($commissionIndex * 2) + ($artistIndex % 3);

                DB::table('commissions')->insert([
                    'artist_id' => $artistId,
                    'component_id' => null,
                    'title' => $commission['title'],
                    'description' => $commission['description'],
                    'base_price' => $commission['base_price'],
                    'currency' => 'CHF',
                    'estimated_days' => $commission['estimated_days'],
                    'max_free_revisions' => $commission['max_free_revisions'],
                    'status' => $commission['status'],
                    'slots_available' => $commission['slots_available'],
                    'created_at' => now()->subDays(45 - $daysOffset),
                    'updated_at' => now()->subDays(20 - ($commissionIndex % 8)),
                ]);
            }
        }
    }
}
