<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_templates', function (Blueprint $table) {

            $table->foreignId('investment_plan_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('task_templates', function (Blueprint $table) {

            $table->dropConstrainedForeignId('investment_plan_id');

        });
    }
};