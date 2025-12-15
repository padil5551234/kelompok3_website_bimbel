<?php

// Set the correct paths for Vercel
define('LARAVEL_START', microtime(true));

// Register The Auto Loader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Handle The Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);