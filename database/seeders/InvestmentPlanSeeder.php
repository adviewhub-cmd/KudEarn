<?php

namespace Database\Seeders;

use App\Models\InvestmentPlan;
use Illuminate\Database\Seeder;

class InvestmentPlanSeeder extends Seeder
{
    public function run(): void
    {
        InvestmentPlan::updateOrCreate(
            ['name' => 'Starter'],
            [
                'investment_amount' => 10.00,
                'duration_days' => 60,
                'tasks_per_day' => 5,
                'daily_reward' => 0.30,
                'status' => true,
                'description' => 'Starter development investment plan.',
            ]
        );

        InvestmentPlan::updateOrCreate(
            ['name' => 'Basic'],
            [
                'investment_amount' => 50.00,
                'duration_days' => 60,
                'tasks_per_day' => 5,
                'daily_reward' => 1.50,
                'status' => true,
                'description' => 'Basic development investment plan.',
            ]
        );

        InvestmentPlan::updateOrCreate(
            ['name' => 'Standard'],
            [
                'investment_amount' => 100.00,
                'duration_days' => 60,
                'tasks_per_day' => 5,
                'daily_reward' => 3.00,
                'status' => true,
                'description' => 'Standard development investment plan.',
            ]
        );
    }
}