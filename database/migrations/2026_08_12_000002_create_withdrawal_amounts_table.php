<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawal_amounts', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Withdrawal Amount
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 16, 2);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Display Order
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Withdrawal Amounts
            |--------------------------------------------------------------------------
            */

            $table->unique('amount');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_amounts');
    }
};