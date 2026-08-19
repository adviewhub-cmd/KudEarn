<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('wallet_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('reference')->unique();

            $table->enum('type', [
                'deposit',
                'investment',
                'task_reward',
                'withdrawal',
                'refund',
                'adjustment',
            ]);

            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'cancelled',
            ])->default('pending');

            $table->decimal('amount', 16, 2);

            $table->decimal('balance_before', 16, 2)->default(0);
            $table->decimal('balance_after', 16, 2)->default(0);

            $table->string('description')->nullable();

            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};