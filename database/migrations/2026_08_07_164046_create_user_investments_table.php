<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_investments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('investment_plan_id')
                ->constrained()
                ->restrictOnDelete();

            // Snapshot of the plan at the time of purchase
            $table->string('plan_name');

            $table->decimal('amount', 12, 2);

            $table->integer('duration_days');

            $table->integer('tasks_per_day');

            $table->decimal('daily_reward', 12, 2);

            $table->decimal('reward_per_task', 12, 4);

            $table->date('start_date')->nullable();

            $table->date('end_date')->nullable();

            $table->integer('days_completed')->default(0);

            $table->decimal('total_reward_earned', 12, 2)->default(0);

            $table->enum('status', [
                'pending',
                'active',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['investment_plan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }
};