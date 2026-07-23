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
            ['production_stage' => 'brief', 'text' => 'Bonjour, je viens de valider ma commande, hâte de voir le résultat !'],
            ['production_stage' => 'production', 'text' => 'J\'ai commencé à travailler sur votre commande, je vous tiendrai au courant de l\'avancement.'],
            ['production_stage' => 'revision', 'text' => 'J\'ai terminé la première version, pouvez-vous me donner vos retours ?'],
            ['production_stage' => 'awaiting_payment', 'text' => 'Merci pour votre travail ! Je vais procéder au paiement maintenant.'],
            ['production_stage' => 'brief', 'text' => 'Je suis impatient de voir le résultat final !'],
            ['production_stage' => 'production', 'text' => 'Je rencontre un petit problème technique, je vais devoir prendre un peu plus de temps.'],
            ['production_stage' => 'revision', 'text' => 'J\'ai apporté les modifications demandées, pouvez-vous vérifier ?'],
            ['production_stage' => 'awaiting_payment', 'text' => 'Le paiement a été effectué, merci pour votre travail !'],
            ['production_stage' => 'brief', 'text' => 'Je viens de valider la commande, merci !'],
            ['production_stage' => 'production', 'text' => 'La commande est presque terminée, je vous enverrai un aperçu bientôt.'],
        ];

        for ($i = 1; $i <= 10; $i++) {
            $order = $orders[$i % $orders->count()];
            $sender = $i % 2 === 0 ? $order->artist_id : $order->client_id;

            DB::table('messages')->insert([
                'order_id' => $order->id,
                'sender_id' => $sender,
                'content' => json_encode($contents[$i - 1]),
                'attachment_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
