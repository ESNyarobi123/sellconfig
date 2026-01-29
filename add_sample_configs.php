<?php

// This script adds sample configs to all plans
// Run with: php add_sample_configs.php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Plan;
use App\Models\Config;

$plans = Plan::all();

foreach ($plans as $plan) {
    for ($i = 1; $i <= 5; $i++) {
        Config::create([
            'plan_id' => $plan->id,
            'content' => 'vpn://config_' . $plan->id . '_' . $i . '@server.example.com:443?type=premium&key=' . bin2hex(random_bytes(16)),
            'status' => 'available'
        ]);
    }
    echo "Added 5 configs to plan: {$plan->name}\n";
}

echo "\n✅ All sample configs created!\n";
