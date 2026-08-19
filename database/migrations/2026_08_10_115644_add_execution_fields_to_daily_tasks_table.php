<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_tasks', function (Blueprint $table) {

            $table->enum('status', [
                'pending',
                'started',
                'completed',
            ])
            ->default('pending')
            ->after('reward');

            $table->timestamp('started_at')
                ->nullable()
                ->after('status');

            $table->timestamp('completed_at')
                ->nullable()
                ->after('started_at');

            $table->unsignedInteger('estimated_seconds')
                ->default(20)
                ->after('completed_at');

            $table->text('instructions')
                ->nullable()
                ->after('estimated_seconds');

        });
    }

    public function down(): void
    {
        Schema::table('daily_tasks', function (Blueprint $table) {

            $table->dropColumn([
                'status',
                'started_at',
                'completed_at',
                'estimated_seconds',
                'instructions',
            ]);

        });
    }
};