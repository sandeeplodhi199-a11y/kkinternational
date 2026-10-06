<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$appDir = __DIR__;

if (file_exists($maintenance = $appDir . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appDir . '/vendor/autoload.php';

(require_once $appDir . '/bootstrap/app.php')
    ->handleRequest(Request::capture());
