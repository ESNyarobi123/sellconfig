<?php

/**
 * Super Fixer for Laravel Livewire Error
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🛠️ Super Fixer: Removing Livewire Cache</h1>";

$cachePath = __DIR__ . '/../bootstrap/cache/';
$files = ['packages.php', 'services.php', 'config.php', 'routes.php'];

foreach ($files as $file) {
    $fullPath = $cachePath . $file;
    echo "Checking: $file... ";
    if (file_exists($fullPath)) {
        if (is_writable($fullPath)) {
            if (unlink($fullPath)) {
                echo "<b style='color:green;'>✅ DELETED</b><br>";
            } else {
                echo "<b style='color:red;'>❌ FAILED TO DELETE</b> (Unlink error)<br>";
            }
        } else {
            echo "<b style='color:orange;'>⚠️ NOT WRITABLE</b> (Check permissions)<br>";
            // Try to change permissions
            chmod($fullPath, 0666);
            if (unlink($fullPath)) {
                echo "<b style='color:green;'>✅ DELETED (after chmod)</b><br>";
            } else {
                echo "<b style='color:red;'>❌ STILL FAILED</b><br>";
            }
        }
    } else {
        echo "<span style='color:gray;'>Already gone / Not found</span><br>";
    }
}

// Try to clear OPcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "✨ OPcache has been reset.<br>";
}

echo "<h3>Check if vendor exists:</h3>";
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo "✅ Vendor/autoload.php found.<br>";
} else {
    echo "❌ <b style='color:red;'>Vendor/autoload.php MISSING!</b> You must run 'composer install' or upload the vendor folder.<br>";
}

echo "<br><a href='/'>Kagua Website sasa</a>";
