<?php

/*
|--------------------------------------------------------------------------
| Kud.Earn Daily Task Configuration
|--------------------------------------------------------------------------
|
| The generation engine uses these templates when it needs to create the
| missing daily tasks for an active user investment.
|
| IMPORTANT:
| - Rewards are NOT configured here.
| - Reward comes from user_investments.reward_per_task.
| - tasks_per_day also comes from user_investments.
| - Existing tasks are never overwritten.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Default task templates
    |--------------------------------------------------------------------------
    |
    | The generator cycles through these templates when an investment requires
    | more tasks than the number of templates.
    |
    | task_type:
    | - none
    | - website
    | - video
    |
    */

    'templates' => [

        [
            'title' =>
                'Daily Task',

            'description' =>
                'Complete this task to earn your daily reward.',

            'task_type' =>
                'none',

            'task_url' =>
                null,

            'estimated_seconds' =>
                20,

            'instructions' =>
                'Complete the assigned task and return to claim your reward.',
        ],

        [
            'title' =>
                'Visit Partner Website',

            'description' =>
                'Visit the assigned partner website.',

            'task_type' =>
                'website',

            /*
            | Keep this null until an actual advertiser/partner URL is
            | configured. Never invent a paid-advertiser destination.
            */
            'task_url' =>
                null,

            'estimated_seconds' =>
                20,

            'instructions' =>
                'Open the assigned website and remain there for the required time.',
        ],

        [
            'title' =>
                'Watch Assigned Video',

            'description' =>
                'Watch the assigned video.',

            'task_type' =>
                'video',

            /*
            | Keep this null until an actual campaign video URL is configured.
            */
            'task_url' =>
                null,

            'estimated_seconds' =>
                20,

            'instructions' =>
                'Open the assigned video and remain there for the required time.',
        ],
    ],
];
