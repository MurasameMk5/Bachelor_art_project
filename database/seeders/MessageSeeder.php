<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * 10 messages répartis sur les commandes existantes.
     * L'expéditeur alterne entre l'artiste et le client de la commande.
     * Nécessite que OrderSeeder ait déjà tourné.
     */
    public function run(): void
    {
        $orders = DB::table('orders')->get();

        if ($orders->isEmpty()) {
            $this->command->warn('Aucune commande trouvée, exécutez OrderSeeder avant MessageSeeder.');
            return;
        }

        $contents = [
            'Bonjour, je viens de valider ma commande, hâte de voir le résultat !',
            'Merci pour votre commande, je commence le brouillon dès demain.',
            'Voici un premier croquis, dites-moi ce que vous en pensez.',
            'J\'aimerais changer la couleur des cheveux si possible.',
            'Pas de souci, je vous envoie une nouvelle version sous peu.',
            'C\'est parfait, j\'adore le résultat !',
            'Petite question sur le délai de livraison restant.',
            'La livraison est prévue pour la fin de semaine.',
            'Merci beaucoup pour votre travail, à bientôt pour une prochaine commande.',
            'N\'hésitez pas si vous avez d\'autres retours à faire.',
        ];

        for ($i = 1; $i <= 10; $i++) {
            $order = $orders[$i % $orders->count()];
            $sender = $i % 2 === 0 ? $order->artist_id : $order->client_id;

            DB::table('messages')->insert([
                'order_id' => $order->id,
                'sender_id' => $sender,
                'content' => $contents[$i - 1],
                'attachment_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
