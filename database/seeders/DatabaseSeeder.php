<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['phone' => '0712345678'],
            [
                'name' => 'Admin',
                'email' => 'admin@sellconfig.com',
                'phone' => '0712345678',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create Default Settings
        $settings = [
            [
                'key' => 'harakapay_api_key',
                'value' => 'hpk_66312bd6617e98af2508f4ab5875b0f6d04321b7463f28fe',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'HarakaPay API Key',
                'description' => 'API key for HarakaPay payment integration',
            ],
            [
                'key' => 'payment_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'payment',
                'label' => 'Payment Enabled',
                'description' => 'Enable or disable payment processing',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'WhatsApp Number',
                'description' => 'WhatsApp number for customer support',
            ],
            [
                'key' => 'site_name',
                'value' => 'SellConfig',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'Name of the website',
            ],
            [
                'key' => 'support_message',
                'value' => '',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Support Message',
                'description' => 'Message to display on the homepage',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Admin user created: phone=0712345678, password=admin123');
        $this->command->info('✅ Default settings created');
    }
}
