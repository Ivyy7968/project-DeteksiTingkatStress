<?php

$tmp = '/tmp/storage';

foreach ([
    "$tmp/app/public",
    "$tmp/framework/cache/data",
    "$tmp/framework/sessions",
    "$tmp/framework/views",
    "$tmp/logs",
    '/tmp/bootstrap/cache',
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

$env = [
    'LARAVEL_STORAGE_PATH' => $tmp,
    'VIEW_COMPILED_PATH'   => "$tmp/framework/views",
    'APP_PACKAGES_CACHE'   => '/tmp/bootstrap/cache/packages.php',
    'APP_SERVICES_CACHE'   => '/tmp/bootstrap/cache/services.php',
    'APP_CONFIG_CACHE'     => '/tmp/bootstrap/cache/config.php',
    'APP_ROUTES_CACHE'     => '/tmp/bootstrap/cache/routes.php',
    'APP_EVENTS_CACHE'     => '/tmp/bootstrap/cache/events.php',
];

foreach ($env as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

require __DIR__ . '/../public/index.php';