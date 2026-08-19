<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Development administrator/test user
        User::updateOrCreate(
            ['email' => 'admin@kudearn.test'],
            [
                'name' => 'KUD.EARN Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Payment methods
        $this->call([
        PaymentMethodSeeder::class,
        ]);
        
        // Investment plans
        $this->call([
            InvestmentPlanSeeder::class,
        ]);

        //Daily task templates
        $this->call([
    TaskTemplateSeeder::class,
]);
    }
    
}