<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_plan_tasks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('investment_plan_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('task_template_id')
                ->constrained()
                ->restrictOnDelete();

            $table->unsignedInteger('display_order')->default(1);

            $table->boolean('is_required')->default(true);

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique([
                'investment_plan_id',
                'task_template_id'
            ], 'investment_plan_task_unique');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_plan_tasks');
    }
};