<?php

namespace Database\Seeders;

use App\Models\InvestmentPlan;
use App\Models\InvestmentPlanTask;
use App\Models\TaskTemplate;
use Illuminate\Database\Seeder;

class InvestmentPlanTaskSeeder extends Seeder
{
    public function run(): void
    {
        InvestmentPlanTask::truncate();

        $plans = InvestmentPlan::all();

        foreach ($plans as $plan) {

            $templates = TaskTemplate::where('status', true)
                ->orderBy('display_order')
                ->get();

            $order = 1;

            foreach ($templates as $template) {

                InvestmentPlanTask::create([

                    'investment_plan_id' => $plan->id,

                    'task_template_id' => $template->id,

                    'display_order' => $order++,

                    'is_required' => true,

                    'status' => true,

                ]);
            }
        }
    }
}