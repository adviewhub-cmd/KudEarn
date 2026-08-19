<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->decimal('deposit_balance', 16, 2)
                ->default(0)
                ->after('balance');

            $table->decimal('withdrawable_balance', 16, 2)
                ->default(0)
                ->after('deposit_balance');
        });

        /*
         * Historical reconciliation
         *
         * Deposit balance =
         * deposits - completed investments
         *
         * Withdrawable balance =
         * completed task rewards - completed withdrawals
         *
         * We intentionally use the transaction ledger rather than
         * user_investments because the ledger represents actual money
         * movement.
         */
        DB::statement("
            UPDATE wallets w
            SET
                deposit_balance = GREATEST(
                    0,
                    w.total_deposited - (
                        SELECT COALESCE(
                            SUM(ABS(t.amount)),
                            0
                        )
                        FROM transactions t
                        WHERE t.wallet_id = w.id
                          AND t.type = 'investment'
                          AND t.status = 'completed'
                    )
                ),

                withdrawable_balance = GREATEST(
                    0,
                    (
                        SELECT COALESCE(
                            SUM(t.amount),
                            0
                        )
                        FROM transactions t
                        WHERE t.wallet_id = w.id
                          AND t.type = 'task_reward'
                          AND t.status = 'completed'
                    )
                    -
                    (
                        SELECT COALESCE(
                            SUM(ABS(t.amount)),
                            0
                        )
                        FROM transactions t
                        WHERE t.wallet_id = w.id
                          AND t.type = 'withdrawal'
                          AND t.status = 'completed'
                    )
                )
        ");

        /*
         * Preserve the existing balance column temporarily.
         *
         * The old balance remains available for rollback/debugging
         * during Phase 5.
         */
    }

    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn([
                'deposit_balance',
                'withdrawable_balance',
            ]);
        });
    }
};