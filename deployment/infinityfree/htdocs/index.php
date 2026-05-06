<?php

/**
 * InfinityFree deployment entrypoint.
 *
 * We keep Laravel app outside web root in ../laravel
 */

define('LARAVEL_START', microtime(true));

$appRoot = __DIR__ . '/../laravel';

if (file_exists($maintenance = $appRoot . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appRoot . '/vendor/autoload.php';

$app = require_once $appRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);

