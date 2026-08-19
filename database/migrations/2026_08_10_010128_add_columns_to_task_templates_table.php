<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_templates', function (Blueprint $table) {

            $table->string('title')->after('id');

            $table->text('description')->nullable()->after('title');

            $table->enum('task_type', [
                'none',
                'website',
                'video',
            ])->default('none')->after('description');

            $table->string('task_url')->nullable()->after('task_type');

            $table->text('instructions')->nullable()->after('task_url');

            $table->unsignedInteger('estimated_seconds')
                ->default(20)
                ->after('instructions');

            $table->unsignedInteger('display_order')
                ->default(1)
                ->after('estimated_seconds');

            $table->boolean('status')
                ->default(true)
                ->after('display_order');
        });
    }

    public function down(): void
    {
        Schema::table('task_templates', function (Blueprint $table) {

            $table->dropColumn([
                'title',
                'description',
                'task_type',
                'task_url',
                'instructions',
                'estimated_seconds',
                'display_order',
                'status',
            ]);

        });
    }
};