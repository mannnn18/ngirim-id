<?php
define('LARAVEL_START', microtime(true));

// Daftarkan autoloader Composer
require __DIR__.'/../vendor/autoload.php';

// Panggil aplikasi Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// === VERCEL HACK: Pindahkan semua aktivitas Storage ke folder /tmp ===
$storagePath = '/tmp/storage';
$directories = [
    $storagePath . '/app/public',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/testing',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
];

// Buat foldernya secara otomatis jika belum ada
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Paksa Laravel menggunakan jalur baru ini
$app->useStoragePath($storagePath);
// ====================================================================

// Tangkap dan jalankan request website
$request = Illuminate\Http\Request::capture();
$app->handleRequest($request);