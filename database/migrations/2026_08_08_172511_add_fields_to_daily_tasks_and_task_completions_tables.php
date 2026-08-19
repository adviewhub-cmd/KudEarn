<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_tasks', function (Blueprint $table) {

            $table->foreignId('user_investment_id')
                ->after('id')
                ->constrained('user_investments')
                ->cascadeOnDelete();

            $table->date('task_date')
                ->after('user_investment_id');

            $table->unsignedInteger('task_number')
                ->after('task_date');

            $table->string('title')
                ->after('task_number');

            $table->text('description')
                ->nullable()
                ->after('title');

            $table->decimal('reward', 12, 4)
                ->default(0)
                ->after('description');

            $table->unique([
                'user_investment_id',
                'task_date',
                'task_number',
            ], 'daily_tasks_unique_task');

            $table->index([
                'user_investment_id',
                'task_date',
            ]);
        });


        Schema::table('task_completions', function (Blueprint $table) {

            $table->foreignId('daily_task_id')
                ->after('id')
                ->constrained('daily_tasks')
                ->cascadeOnDelete();

            $table->foreignId('user_investment_id')
                ->after('daily_task_id')
                ->constrained('user_investments')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->after('user_investment_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('reward', 12, 4)
                ->default(0);

            $table->timestamp('completed_at')
                ->nullable();

            $table->foreignId('transaction_id')
                ->nullable()
                ->constrained('transactions')
                ->nullOnDelete();

            $table->unique(
                'daily_task_id',
                'task_completions_daily_task_unique'
            );

            $table->index([
                'user_id',
                'user_investment_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('task_completions', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['user_investment_id']);
            $table->dropForeign(['daily_task_id']);

            $table->dropUnique('task_completions_daily_task_unique');

            $table->dropIndex([
                'user_id',
                'user_investment_id',
            ]);

            $table->dropColumn([
                'daily_task_id',
                'user_investment_id',
                'user_id',
                'reward',
                'completed_at',
                'transaction_id',
            ]);
        });

        Schema::table('daily_tasks', function (Blueprint $table) {
            $table->dropForeign(['user_investment_id']);

            $table->dropUnique('daily_tasks_unique_task');

            $table->dropIndex([
                'user_investment_id',
                'task_date',
            ]);

            $table->dropColumn([
                'user_investment_id',
                'task_date',
                'task_number',
                'title',
                'description',
                'reward',
            ]);
        });
    }
};