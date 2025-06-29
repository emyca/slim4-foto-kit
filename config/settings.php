<?php

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Error reporting for production
//error_reporting(0);
//ini_set('display_errors', '0');

// Load default settings
$settings = require __DIR__ . '/defaults.php';

// Load secret configuration
if (file_exists(dirname(__DIR__, 2) . '/env.php')) {
     // Take env outside project dir if existing
    require dirname(__DIR__, 2) . '/env.php';
} elseif (file_exists(__DIR__ . '/env/env.php')) {
    require __DIR__ . '/env/env.php';
}

// Set APP_ENV if not already set.
// Options: 'dev', 'prod'
$_ENV['APP_ENV'] = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'dev';

// Overwrite previous config with APP_ENV specific values.
// Options: 'dev', 'prod'
if (isset($_ENV['APP_ENV'])) {
    $appEnvConfigFile = __DIR__ . '/env/env.' . $_ENV['APP_ENV'] . '.php';
    if (file_exists($appEnvConfigFile)) {
        require $appEnvConfigFile;
    }
}

return $settings;
