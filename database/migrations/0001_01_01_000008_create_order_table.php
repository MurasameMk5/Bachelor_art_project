<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('commission_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('base_price');
            $table->unsignedInteger('final_price');
            $table->unsignedInteger('max_free_revisions');
            $table->unsignedInteger('current_revision_count')->default(0);
            $table->enum('status', ['to do', 'doing', 'done', 'cancelled',])->default('to do');
            $table->enum('production_stage', ['brief', 'production', 'revision', 'awaiting_payment',])->nullable();
            $table->boolean('awaiting_confirmation')->default(false);
            $table->string('invoice_number')->unique();
            $table->timestamp('invoice_generated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
