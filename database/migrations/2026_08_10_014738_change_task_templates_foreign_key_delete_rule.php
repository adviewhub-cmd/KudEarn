<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_templates', function (Blueprint $table) {

            // Drop existing foreign key
            $table->dropForeign(['investment_plan_id']);

            // Recreate with RESTRICT
            $table->foreign('investment_plan_id')
                ->references('id')
                ->on('investment_plans')
                ->restrictOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('task_templates', function (Blueprint $table) {

            $table->dropForeign(['investment_plan_id']);

            $table->foreign('investment_plan_id')
                ->references('id')
                ->on('investment_plans')
                ->cascadeOnDelete();

        });
    }
};