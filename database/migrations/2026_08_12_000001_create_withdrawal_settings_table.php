<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawal_settings', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | General Withdrawal Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('withdrawal_enabled')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Allowed Withdrawal Days
            |--------------------------------------------------------------------------
            |
            | Stored as JSON:
            |
            | ["monday", "wednesday", "friday"]
            |
            */

            $table->json('withdrawal_days')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Withdrawal Fee
            |--------------------------------------------------------------------------
            |
            | fixed
            | percentage
            |
            */

            $table->enum('fee_type', [
                'fixed',
                'percentage',
            ])->default('fixed');

            $table->decimal('fee_value', 16, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Minimum Withdrawable Balance
            |--------------------------------------------------------------------------
            */

            $table->decimal('minimum_withdrawable_balance', 16, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Optional Admin Notes
            |--------------------------------------------------------------------------
            */

            $table->text('admin_note')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_settings');
    }
};