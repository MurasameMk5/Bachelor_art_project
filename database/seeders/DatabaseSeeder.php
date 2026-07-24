<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StorefrontSeeder::class,
            CommissionSeeder::class,
            CommissionImageSeeder::class,
            StorefrontComponentSeeder::class,
            QuestionSeeder::class,
            OrderSeeder::class,
            AnswerSeeder::class,
            ContractSeeder::class,
            EscrowSeeder::class,
            DeliverableSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
