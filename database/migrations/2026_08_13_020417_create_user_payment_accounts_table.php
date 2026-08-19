<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_payment_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('payment_method_id')
                ->constrained('payment_methods')
                ->restrictOnDelete();

            /*
             * Method-specific account data.
             *
             * Example:
             * {
             *     "email": "user@example.com"
             * }
             *
             * or:
             *
             * {
             *     "network": "TRC20",
             *     "wallet_address": "TX..."
             * }
             */
            $table->json('account_details');

            $table->boolean('is_default')
                ->default(false);

            /*
             * Reserved for future verification
             * systems / payment APIs.
             */
            $table->boolean('is_verified')
                ->default(false);

            $table->timestamps();

            $table->index([
                'user_id',
                'payment_method_id',
            ]);

            $table->index([
                'user_id',
                'is_default',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_payment_accounts');
    }
};