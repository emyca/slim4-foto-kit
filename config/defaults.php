<?php

// Application default settings

// Init settings var
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

// Error Handling Middleware settings
$settings['error'] = [
    
    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,

    'display_error_details' => true,
];

// Database
$settings['db'] = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => 'root',
    'database' => 'demo_db',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'flags' => [
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ],
    'table' => [
        'fotos' => 'place_holder',
    ]
];

// Twig
$settings['twig'] = [
    // Template paths
    'paths' => [
        __DIR__ . '/../templates',
    ],
    // Twig environment options
    'options' => [
        'cache_path' => __DIR__ . '/../tmp/twig',
        'cache_enabled' => false,
    ],
];

// URL
$settings['url'] = [
    'uploadsDir' => __DIR__ . '/../public/uploads',
    // It's better works through absolute url (set yours).
    'uploadsUrl' => 'http://localhost/_SlimPHP/slim4-foto-kit/public/uploads/',
    'uploadsSubUrl' => './uploads/',
    // Redirect url in Admin Authorization Middleware. 
    // It's better works through absolute url (set yours).
    'adminSignIn' => 'http://localhost/_SlimPHP/slim4-foto-kit/admin/signin',
    // Redirect url in Admin Auth Service.
    // It's better works through absolute url (set yours).    
    'adminFotos' => 'http://localhost/_SlimPHP/slim4-foto-kit/admin/fotos',
    // Admin auth file path. 
    'adminAuthFile' => "../private/admin_data.json",
];

// JWT
$settings['jwt'] = [
    'issuer' => 'local.dev',
    'audience' => 'local.dev',
    'cookie_name' => 'fotoapp',    
];

return $settings;
