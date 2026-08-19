<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_templates', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->text('description')->nullable();

            $table->enum('task_type', [
                'none',
                'website',
                'video',
            ])->default('none');

            $table->string('task_url')->nullable();

            $table->text('instructions')->nullable();

            $table->unsignedInteger('estimated_seconds')->default(20);

            $table->unsignedInteger('display_order')->default(1);

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_templates');
    }
};