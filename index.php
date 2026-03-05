<?php

declare (strict_types = 1);

/**
 * Environment setup: prod | dev
 */
$env = 'dev';

if ($env === 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

define('BASE_PATH', __DIR__);

require BASE_PATH . '/vendor/autoload.php';

use App\Core\Route;

/**
 * Application entry point
 */
try {
    $route = new Route('/', $_SERVER['REQUEST_METHOD']);
    $route->handle();
} catch (\Throwable $e) {
    if ($env === 'dev') {
        echo $e->getMessage();
    } else {
        echo 'Something went wrong.';
    }
}
