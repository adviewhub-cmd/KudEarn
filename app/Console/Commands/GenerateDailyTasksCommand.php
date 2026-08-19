<?php

namespace App\Console\Commands;

use App\Services\DailyTaskGeneratorService;
use Illuminate\Console\Command;
use Throwable;

class GenerateDailyTasksCommand extends Command
{
    protected $signature = 'kudearn:generate-daily-tasks
                            {--date= : Generate tasks for a specific date}';

    protected $description = 'Generate daily tasks for all active investments';

    public function handle(
        DailyTaskGeneratorService $generator
    ): int {
        $date = $this->option('date');

        $this->info(
            'Generating daily tasks'
            . ($date ? " for {$date}" : ' for today')
            . '...'
        );

        try {

            $count = $generator->generateForActiveInvestments(
                $date
            );

            $this->info(
                "Daily task generation completed. {$count} task(s) processed."
            );

            return self::SUCCESS;

        } catch (Throwable $e) {

            $this->error(
                'Daily task generation failed: '
                . $e->getMessage()
            );

            report($e);

            return self::FAILURE;
        }
    }
}