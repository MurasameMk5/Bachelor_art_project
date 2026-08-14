<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Conversations réalistes entre client et artiste.
     * Nécessite que OrderSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $orders = DB::table('orders')
            ->orderBy('id')
            ->get(['id', 'artist_id', 'client_id', 'production_stage']);

        if ($orders->isEmpty()) {
            $this->command->warn('Aucune commande trouvée, exécutez OrderSeeder avant MessageSeeder.');
            return;
        }

        $threadsByStage = [
            'brief' => [
                ['from' => 'client', 'text' => 'Bonjour ! Je confirme le brief et les références envoyées.'],
                ['from' => 'artist', 'text' => 'Parfait, merci. Je vous envoie un premier rough sous 48h.'],
                ['from' => 'client', 'text' => 'Super, hâte de voir la proposition.'],
            ],
            'production' => [
                ['from' => 'artist', 'text' => 'La composition principale est posée, je peaufine les lumières.'],
                ['from' => 'client', 'text' => 'Top, je valide bien cette direction.'],
                ['from' => 'artist', 'text' => 'Merci pour le retour rapide, je continue la finalisation.'],
            ],
            'revision' => [
                ['from' => 'artist', 'text' => 'Version 1 livrée. Je suis preneur de vos retours détaillés.'],
                ['from' => 'client', 'text' => 'Pouvez-vous renforcer le contraste et ajuster le fond ?'],
                ['from' => 'artist', 'text' => 'Bien reçu, je vous envoie la révision ce soir.'],
            ],
            'awaiting_payment' => [
                ['from' => 'artist', 'text' => 'Livraison finale effectuée avec fichiers HD.'],
                ['from' => 'client', 'text' => 'Tout est conforme, je procède au paiement dans la journée.'],
                ['from' => 'artist', 'text' => 'Merci beaucoup pour votre confiance !'],
            ],
            'final_delivery' => [
                ['from' => 'artist', 'text' => 'Merci encore pour le projet, le dossier final reste accessible ici.'],
                ['from' => 'client', 'text' => 'Travail impeccable, je reviendrai pour une prochaine commande.'],
            ],
        ];

        foreach ($orders as $order) {
            $threadStage = $order->production_stage ?? 'brief';
            $thread = $threadsByStage[$threadStage] ?? $threadsByStage['brief'];

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
