<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payout_attempts', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Withdrawal
            |--------------------------------------------------------------------------
            */

            $table->foreignId('withdrawal_id')
                ->unique()
                ->constrained('withdrawals')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Provider
            |--------------------------------------------------------------------------
            |
            | Examples:
            | bank
            | crypto
            | faucetpay
            |
            */

            $table->string('provider', 100);

            /*
            |--------------------------------------------------------------------------
            | Provider Reference
            |--------------------------------------------------------------------------
            |
            | Filled when the external provider returns its own transaction ID.
            |
            */

            $table->string('provider_reference', 191)
                ->nullable()
                ->index();

            /*
            |--------------------------------------------------------------------------
            | Payout Status
            |--------------------------------------------------------------------------
            */

            $table->string('status', 30)
                ->default('pending')
                ->index();

            /*
            |--------------------------------------------------------------------------
            | Amount Snapshot
            |--------------------------------------------------------------------------
            |
            | This is the actual amount the provider should pay.
            |
            | It must be the withdrawal net_amount.
            |
            */

            $table->decimal('amount', 16, 2);

            /*
            |--------------------------------------------------------------------------
            | Attempt Information
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('attempt_count')
                ->default(0);

            $table->text('error_message')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Provider Payloads
            |--------------------------------------------------------------------------
            |
            | Reserved for future API integrations.
            |
            */

            $table->json('request_payload')
                ->nullable();

            $table->json('response_payload')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Processing Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('last_attempt_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'provider',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payout_attempts');
    }
};