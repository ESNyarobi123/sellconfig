<?php

/**
 * Hili faili litafuta cache za Laravel ambazo zinasababisha error ya Livewire kwenye server.
 */

$cacheFiles = [
    __DIR__ . '/../bootstrap/cache/packages.php',
    __DIR__ . '/../bootstrap/cache/services.php',
    __DIR__ . '/../bootstrap/cache/config.php',
    __DIR__ . '/../bootstrap/cache/routes.php'
];

echo "<h2>🛠️ Kipanga Mfumo (Fix Server Tool)</h2>";

foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "✅ Imefutwa: " . basename($file) . "<br>";
        } else {
            echo "❌ Imeshindikana kufuta: " . basename($file) . " (Check permissions)<br>";
        }
    } else {
        echo "ℹ️ Haipo/Ilishafutwa: " . basename($file) . "<br>";
    }
}

echo "<br><b>Sasa jaribu tena kufungua website yako au run_migrations.php</b>";
