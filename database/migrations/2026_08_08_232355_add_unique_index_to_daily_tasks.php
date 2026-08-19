<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The unique index already exists on daily_tasks.
        // Nothing to do.
    }

    public function down(): void
    {
        // Nothing to undo.
    }
};