<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Kud.Earn Daily Task Scheduler
|--------------------------------------------------------------------------
|
| 00:05:
| Generate today's tasks for every active investment.
|
| The existing DailyTaskGeneratorService remains the authoritative
| generation engine.
|
*/

Schedule::command(
    'daily-tasks:generate'
)->dailyAt('00:05');

/*
|--------------------------------------------------------------------------
| Kud.Earn Investment Lifecycle Scheduler
|--------------------------------------------------------------------------
|
| 00:10:
| Mark investments whose inclusive end_date has passed as completed.
|
| Pending investments are NOT automatically activated here because an
| investment must only become active after successful payment/purchase
| confirmation.
|
*/

Schedule::command(
    'investments:lifecycle'
)->dailyAt('00:10');
