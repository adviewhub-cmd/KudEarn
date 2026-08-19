<?php

namespace App\Console\Commands;

use App\Services\InvestmentProgressionService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Throwable;

class ReconcileInvestmentProgress extends Command
{
    protected $signature = 'investments:progress
                            {--date= : Date to reconcile, YYYY-MM-DD}';

    protected $description =
        'Reconcile completed daily tasks and investment day progress';

    public function __construct(
        protected InvestmentProgressionService $progression
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $date = $this->option('date');

        if ($date !== null) {
            $parsed = Carbon::createFromFormat(
                'Y-m-d',
                $date
            );

            if (
                ! $parsed ||
                $parsed->format('Y-m-d') !== $date
            ) {
                $this->error(
                    'Invalid date. Use YYYY-MM-DD.'
                );

                return self::FAILURE;
            }
        }

        try {
            $processed = $this->progression
                ->reconcileActiveInvestments(
                    $date
                        ? Carbon::parse($date)
                        : null
                );

            $this->table(
                ['Metric', 'Value'],
                [
                    [
                        'Date',
                        $date ?: today()->toDateString(),
                    ],
                    [
                        'Investments Progressed',
                        $processed,
                    ],
                ]
            );

            $this->info(
                'Investment progress reconciliation completed.'
            );

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error(
                'Investment progress reconciliation failed: '
                . $exception->getMessage()
            );

            report($exception);

            return self::FAILURE;
        }
    }
}
