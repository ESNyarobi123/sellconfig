<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Weekly Plans
        Plan::updateOrCreate(
            ['name' => 'Weekly Normal'],
            [
                'price' => 2000,
                'duration' => '7 Days',
                'type' => 'weekly',
                'description' => 'Speed KBs 100 to 500kbs',
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Weekly Middle'],
            [
                'price' => 3000,
                'duration' => '7 Days',
                'type' => 'weekly',
                'description' => 'Speed KBs 500 to 700kbs',
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Sku 11 Offer'],
            [
                'price' => 5000,
                'duration' => '11 Days',
                'type' => 'weekly',
                'description' => 'Speed KBs 700 to 1MBs & 3Mbps',
                'is_active' => true,
            ]
        );

        // 2 Weekly Plans
        Plan::updateOrCreate(
            ['name' => '2 Weeks Basic'],
            [
                'price' => 4000,
                'duration' => '14 Days',
                'type' => 'bi_weekly',
                'description' => 'Unlimited',
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => '2 Weeks Pro'],
            [
                'price' => 5000,
                'duration' => '14 Days',
                'type' => 'bi_weekly',
                'description' => 'Unlimited',
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Sku 18 Unlimited'],
            [
                'price' => 8000,
                'duration' => '18 Days',
                'type' => 'bi_weekly',
                'description' => 'Unlimited',
                'is_active' => true,
            ]
        );

        // Monthly Plans
        Plan::updateOrCreate(
            ['name' => 'Monthly Normal'],
            [
                'price' => 8000,
                'duration' => '30 Days',
                'type' => 'monthly',
                'description' => 'Unlimited Normal',
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['name' => 'Monthly Middle'],
            [
                'price' => 10000,
                'duration' => '30 Days',
                'type' => 'monthly',
                'description' => 'Unlimited Middle',
                'is_active' => true,
            ]
        );
    }
}
