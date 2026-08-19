<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User / Wallet
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Selected Withdrawal Amount
            |--------------------------------------------------------------------------
            */

            $table->foreignId('withdrawal_amount_id')
                ->nullable()
                ->constrained('withdrawal_amounts')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Financial Amounts
            |--------------------------------------------------------------------------
            |
            | amount     = amount deducted from withdrawable balance
            | fee        = admin withdrawal fee
            | net_amount = amount actually paid to member
            |
            */

            $table->decimal('amount', 16, 2);

            $table->decimal('fee', 16, 2)
                ->default(0);

            $table->decimal('net_amount', 16, 2);

            /*
            |--------------------------------------------------------------------------
            | Fee Configuration Snapshot
            |--------------------------------------------------------------------------
            |
            | We store the fee configuration used at the time of the request.
            | This prevents future admin setting changes from altering old
            | withdrawal records.
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
            | Withdrawal Method
            |--------------------------------------------------------------------------
            */

            $table->string('method', 100);

            /*
            |--------------------------------------------------------------------------
            | Payment Destination
            |--------------------------------------------------------------------------
            |
            | Examples:
            |
            | Bank account
            | Crypto wallet
            | FaucetPay
            | Airtm
            |
            */

            $table->text('account_details');

            /*
            |--------------------------------------------------------------------------
            | Withdrawal Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'cancelled',
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Reference
            |--------------------------------------------------------------------------
            */

            $table->string('reference', 100)
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Administrator Notes
            |--------------------------------------------------------------------------
            */

            $table->text('admin_note')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Processing Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamp('requested_at')
                ->nullable();

            $table->timestamp('approved_at')
                ->nullable();

            $table->timestamp('rejected_at')
                ->nullable();

            $table->timestamp('processed_at')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'user_id',
                'status',
            ]);

            $table->index([
                'wallet_id',
                'status',
            ]);

            $table->index('requested_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};