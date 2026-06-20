<?php

// 1. Alihkan semua file sistem internal Laravel ke folder /tmp (Folder yang tidak dikunci Vercel)
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');
putenv('VIEW_COMPILED_PATH=/tmp/views');

// 2. Buat kerangka folder Storage sementara
$storagePath = '/tmp/storage';
$directories = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/testing',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    '/tmp/views'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 3. Panggil sistem Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// 4. Paksa Laravel menggunakan jalur Storage yang baru
$app->useStoragePath($storagePath);

// 5. Tangkap request dan jalankan aplikasi
$app->handleRequest(Illuminate\Http\Request::capture());