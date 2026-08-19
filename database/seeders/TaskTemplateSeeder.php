<?php

namespace Database\Seeders;

use App\Models\TaskTemplate;
use Illuminate\Database\Seeder;

class TaskTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [

            /*
            |--------------------------------------------------------------------------
            | Starter Plan (Investment Plan ID = 1)
            |--------------------------------------------------------------------------
            */

            [
                'investment_plan_id' => 1,
                'title' => 'Visit OpenAI',
                'description' => 'Visit the OpenAI website.',
                'task_type' => 'website',
                'task_url' => 'https://openai.com',
                'instructions' => 'Remain on the website for at least 20 seconds.',
                'estimated_seconds' => 20,
                'display_order' => 1,
                'status' => true,
            ],

            [
                'investment_plan_id' => 1,
                'title' => 'Visit Laravel',
                'description' => 'Visit Laravel official website.',
                'task_type' => 'website',
                'task_url' => 'https://laravel.com',
                'instructions' => 'Remain on the page for at least 20 seconds.',
                'estimated_seconds' => 20,
                'display_order' => 2,
                'status' => true,
            ],

            /*
            |--------------------------------------------------------------------------
            | Premium Plan (Investment Plan ID = 2)
            |--------------------------------------------------------------------------
            */

            [
                'investment_plan_id' => 2,
                'title' => 'Watch Product Video',
                'description' => 'Watch the assigned product video.',
                'task_type' => 'video',
                'task_url' => 'https://youtube.com',
                'instructions' => 'Watch for at least 30 seconds.',
                'estimated_seconds' => 30,
                'display_order' => 1,
                'status' => true,
            ],

            /*
            |--------------------------------------------------------------------------
            | Ultimate Plan (Investment Plan ID = 3)
            |--------------------------------------------------------------------------
            */

            [
                'investment_plan_id' => 3,
                'title' => 'Visit Partner Website',
                'description' => 'Visit the partner website.',
                'task_type' => 'website',
                'task_url' => 'https://example.com',
                'instructions' => 'Remain on the page for at least 25 seconds.',
                'estimated_seconds' => 25,
                'display_order' => 1,
                'status' => true,
            ],
        ];

        foreach ($templates as $template) {
            TaskTemplate::updateOrCreate(
                [
                    'investment_plan_id' => $template['investment_plan_id'],
                    'display_order'      => $template['display_order'],
                ],
                $template
            );
        }
    }
}