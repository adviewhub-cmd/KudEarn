<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_plans', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->decimal('investment_amount',12,2);

            $table->integer('duration_days');

            $table->integer('tasks_per_day');

            $table->decimal('daily_reward',12,2);

            $table->boolean('status')->default(true);

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_plans');
    }
};