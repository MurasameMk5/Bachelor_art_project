<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Realistic conversations between client and artist.
     * Requires OrderSeeder to be executed first.
     */
    public function run(): void
    {
        $orders = DB::table('orders')
            ->orderBy('id')
            ->get(['id', 'artist_id', 'client_id', 'production_stage']);

        if ($orders->isEmpty()) {
            $this->command->warn('No orders found. Please run OrderSeeder before MessageSeeder.');
            return;
        }

        // Threads adapted to match the specific stages defined in OrderSeeder
        $threadsByStage = [
            'brief' => [
                ['from' => 'client', 'text' => 'Hi! I just reviewed the brief. Everything looks correct, and the references I attached should give you a good idea of the vibe I am going for.'],
                ['from' => 'artist', 'text' => 'Perfect, thank you! I have everything I need. I will start working on the contract and send it over within the next few days.'],
                ['from' => 'client', 'text' => 'Thank you!'],
            ],
            'production' => [
                ['from' => 'artist', 'text' => 'Hi there! I have uploaded the initial sketches and a render for you to check out. Let me know what you think of the direction so far.'],
                ['from' => 'client', 'text' => 'It looks amazing! The composition is exactly what I had in mind. The rendering is gorgeous.'],
                ['from' => 'artist', 'text' => 'Glad you like it! I will keep working on the details and final rendering now.'],
            ],
            'revision' => [
                ['from' => 'artist', 'text' => 'Hello! I have uploaded the latest version. Let me know if everything is to your liking or if you need any final adjustments.'],
                ['from' => 'artist', 'text' => 'I have received your revision request. I will make those adjustments and get back to you with the updated version shortly.'],
            ],
            'awaiting_payment' => [
                ['from' => 'artist', 'text' => 'Great news! The artwork is fully complete. I have generated the final invoice for the remaining balance. Once paid, I will release the high-res files.'],
                ['from' => 'client', 'text' => 'It looks absolutely fantastic! I will process the payment right away.'],
                ['from' => 'artist', 'text' => 'Payment received, thank you so much! I am preparing your final files now.'],
            ],
            'final_delivery' => [
                ['from' => 'artist', 'text' => 'Thank you again for your trust! I have attached the final high-resolution files to the delivery tab. It was a real pleasure working with you on this project.'],
                ['from' => 'client', 'text' => 'Files received! The final result is absolutely stunning. I will definitely come back for future commissions!'],
            ],
        ];

        foreach ($orders as $order) {
            $threadStage = $order->production_stage;
            $thread = $threadsByStage[$threadStage] ?? [];

            foreach ($thread as $step => $message) {
                DB::table('messages')->insert([
                    'order_id' => $order->id,
                    'sender_id' => $message['from'] === 'artist' ? $order->artist_id : $order->client_id,
                    'content' => json_encode([
                        'production_stage' => $threadStage,
                        'text' => $message['text'],
                    ], JSON_UNESCAPED_UNICODE),
                    'attachment_path' => null,
                    'created_at' => now()->subDays(6 - $step),
                    'updated_at' => now()->subDays(6 - $step),
                ]);
            }
        }
    }
}
