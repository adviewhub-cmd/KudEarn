<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('daily_tasks', 'task_type')) {
                $table->string('task_type')
                    ->default('none')
                    ->after('reward');
            }

            if (!Schema::hasColumn('daily_tasks', 'task_url')) {
                $table->text('task_url')
                    ->nullable()
                    ->after('task_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('daily_tasks', function (Blueprint $table) {
            if (Schema::hasColumn('daily_tasks', 'task_url')) {
                $table->dropColumn('task_url');
            }

            if (Schema::hasColumn('daily_tasks', 'task_type')) {
                $table->dropColumn('task_type');
            }
        });
    }
};