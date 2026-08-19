<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'payout_attempts',
            function (Blueprint $table): void {
                $table->string(
                    'idempotency_key',
                    191
                )
                    ->nullable()
                    ->unique(
                        'payout_attempts_idempotency_key_unique'
                    )
                    ->after('withdrawal_id');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'payout_attempts',
            function (Blueprint $table): void {
                $table->dropUnique(
                    'payout_attempts_idempotency_key_unique'
                );

                $table->dropColumn(
                    'idempotency_key'
                );
            }
        );
    }
};