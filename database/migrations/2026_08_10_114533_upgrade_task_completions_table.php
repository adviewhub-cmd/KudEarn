<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_completions', function (Blueprint $table) {

            $table->timestamp('started_at')
                ->nullable()
                ->after('reward');

            $table->unsignedInteger('completion_seconds')
                ->default(0)
                ->after('completed_at');

            $table->enum('status', [
                'started',
                'completed',
                'rejected',
            ])
                ->default('started')
                ->after('completion_seconds');

            $table->ipAddress('ip_address')
                ->nullable()
                ->after('status');

            $table->text('user_agent')
                ->nullable()
                ->after('ip_address');

            $table->json('verification_data')
                ->nullable()
                ->after('user_agent');

        });
    }

    public function down(): void
    {
        Schema::table('task_completions', function (Blueprint $table) {

            $table->dropColumn([
                'started_at',
                'completion_seconds',
                'status',
                'ip_address',
                'user_agent',
                'verification_data',
            ]);

        });
    }
};