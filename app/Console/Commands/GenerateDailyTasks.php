<?php

namespace App\Console\Commands;

use App\Services\DailyTaskGeneratorService;
use Illuminate\Console\Command;
use Throwable;

class GenerateDailyTasks extends Command
{
    protected $signature = 'daily-tasks:generate
                            {date? : Date to generate tasks for, YYYY-MM-DD}';

    protected $description = 'Generate daily tasks for all active user investments';

    public function __construct(
        protected DailyTaskGeneratorService $generator
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $date = $this->argument('date');

        if ($date !== null) {
            $parsed = \DateTime::createFromFormat('Y-m-d', $date);

            if (
                ! $parsed ||
                $parsed->format('Y-m-d') !== $date
            ) {
                $this->error('Invalid date. Use YYYY-MM-DD.');

                return self::FAILURE;
            }
        }

        $displayDate = $date ?: now()->toDateString();

        $this->info(
            "Generating daily tasks for {$displayDate}..."
        );

        try {
            $generated = $this->generator
                ->generateForActiveInvestments($date);

            $this->newLine();

            $this->table(
                ['Metric', 'Value'],
                [
                    ['Date', $displayDate],
                    ['Tasks Generated/Existing Returned', $generated],
                ]
            );

            $this->info(
                'Daily task generation completed successfully.'
            );

            return self::SUCCESS;

        } catch (Throwable $exception) {

            $this->error(
                'Daily task generation failed: '
                . $exception->getMessage()
            );

            report($exception);

            return self::FAILURE;
        }
    }
}
