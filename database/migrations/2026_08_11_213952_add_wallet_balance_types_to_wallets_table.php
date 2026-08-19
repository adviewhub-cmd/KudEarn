<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Existing columns
        |--------------------------------------------------------------------------
        |
        | deposit_balance and withdrawable_balance already exist in this
        | database, so do NOT attempt to create them again.
        |
        */

        /*
        |--------------------------------------------------------------------------
        | Reconcile wallet balances
        |--------------------------------------------------------------------------
        |
        | Existing transaction history is used to verify/rebuild the two
        | separate wallet balances.
        |
        */

        DB::statement("
            UPDATE wallets w
            SET
                w.deposit_balance = (
                    SELECT COALESCE(
                        SUM(
                            CASE
                                WHEN t.type = 'deposit'
                                    THEN t.amount

                                WHEN t.type = 'investment'
                                    THEN -t.amount

                                ELSE 0
                            END
                        ),
                        0
                    )
                    FROM transactions t
                    WHERE t.wallet_id = w.id
                      AND t.status = 'completed'
                ),

                w.withdrawable_balance = (
                    SELECT COALESCE(
                        SUM(
                            CASE
                                WHEN t.type = 'task_reward'
                                    THEN t.amount

                                WHEN t.type = 'refund'
                                    THEN t.amount

                                WHEN t.type = 'adjustment'
                                    THEN t.amount

                                WHEN t.type = 'withdrawal'
                                    THEN -t.amount

                                ELSE 0
                            END
                        ),
                        0
                    )
                    FROM transactions t
                    WHERE t.wallet_id = w.id
                      AND t.status = 'completed'
                )
        ");

        /*
        |--------------------------------------------------------------------------
        | Synchronize legacy balance
        |--------------------------------------------------------------------------
        */

        DB::statement("
            UPDATE wallets
            SET balance =
                ROUND(
                    deposit_balance + withdrawable_balance,
                    2
                )
        ");
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | These columns existed before this migration was executed.
        | Therefore this migration must NOT delete them on rollback.
        |
        */
    }
};