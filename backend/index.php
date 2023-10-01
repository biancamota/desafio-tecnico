<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

use Bm\Store\Config\Enviroment;
use Bm\Store\Database\Connection;
use Bm\Store\Routing\Router;

require_once __DIR__ . '/vendor/autoload.php';

Enviroment::loadEnv();
$db = new Connection();
$router = new Router;

require_once __DIR__.'/src/routes/api.php';

$router->init();