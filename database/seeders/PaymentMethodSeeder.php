<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::updateOrCreate(
            ['slug' => 'bank-transfer'],
            [
                'name' => 'Bank Transfer',

                'description' =>
                    'Receive your withdrawal through a bank account.',

                'fields' => [
                    [
                        'name' => 'bank_name',
                        'label' => 'Bank Name',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'name' => 'account_name',
                        'label' => 'Account Name',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'name' => 'account_number',
                        'label' => 'Account Number',
                        'type' => 'text',
                        'required' => true,
                    ],
                ],

                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        PaymentMethod::updateOrCreate(
            ['slug' => 'crypto'],
            [
                'name' => 'Crypto',

                'description' =>
                    'Receive your withdrawal to a cryptocurrency wallet.',

                'fields' => [
                    [
                        'name' => 'network',
                        'label' => 'Network',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'name' => 'wallet_address',
                        'label' => 'Wallet Address',
                        'type' => 'text',
                        'required' => true,
                    ],
                ],

                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        PaymentMethod::updateOrCreate(
            ['slug' => 'faucetpay'],
            [
                'name' => 'FaucetPay',

                'description' =>
                    'Receive your withdrawal through FaucetPay.',

                'fields' => [
                    [
                        'name' => 'email',
                        'label' => 'FaucetPay Email',
                        'type' => 'email',
                        'required' => true,
                    ],
                ],

                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        PaymentMethod::updateOrCreate(
            ['slug' => 'airtm'],
            [
                'name' => 'Airtm',

                'description' =>
                    'Receive your withdrawal through Airtm.',

                'fields' => [
                    [
                        'name' => 'email',
                        'label' => 'Airtm Email',
                        'type' => 'email',
                        'required' => true,
                    ],
                ],

                'is_active' => true,
                'sort_order' => 4,
            ]
        );
    }
}