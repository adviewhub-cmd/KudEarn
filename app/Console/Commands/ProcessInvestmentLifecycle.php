<?php

namespace App\Console\Commands;

use App\Services\InvestmentLifecycleService;
use Illuminate\Console\Command;
use Throwable;

class ProcessInvestmentLifecycle extends Command
{
    protected $signature = 'investments:lifecycle
                            {--date= : Processing date, YYYY-MM-DD}';

    protected $description =
        'Complete active investments whose end date has passed';

    public function __construct(
        protected InvestmentLifecycleService $lifecycle
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $date = $this->option('date');

        if ($date !== null) {
            $parsed = \DateTime::createFromFormat(
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
            $completed = $this->lifecycle
                ->processExpiredInvestments(
                    $date
                        ? \Carbon\Carbon::parse($date)
                        : null
                );

            $this->table(
                ['Metric', 'Value'],
                [
                    [
                        'Processing Date',
                        $date ?: now()->toDateString(),
                    ],
                    [
                        'Investments Completed',
                        $completed,
                    ],
                ]
            );

            $this->info(
                'Investment lifecycle processing completed.'
            );

            return self::SUCCESS;

        } catch (Throwable $exception) {

            $this->error(
                'Investment lifecycle processing failed: '
                . $exception->getMessage()
            );

            report($exception);

            return self::FAILURE;
        }
    }
}
