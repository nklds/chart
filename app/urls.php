<?php


namespace App;

use App\Controllers\ApiController;
use App\Controllers\SiteController;
use app\Core\Request;

/**
 * @var $router \app\Core\Router
 */


$router->get('/^\/$/', [SiteController::class, 'index']);
$router->get('/^\/api$/', [ApiController::class, 'index']);
$router->get('/^\/api\/(month|day|week|year|initial)$/', [ApiController::class, 'chart']);