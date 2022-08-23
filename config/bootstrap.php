<?php

use DI\Container;

use DI\Bridge\Slim\Bridge as SlimAppFactory;
// use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$containner = new Container();
// $containner->set("up", __DIR__ . '/../public/uploads');


$settings = require_once __DIR__ . '/settings.php';
$settings($containner);



$app = SlimAppFactory::create($containner);


$middleware = require_once __DIR__ . '/middleware.php';
$middleware($app);

$routes = require_once __DIR__ . '/routes.php';
$routes($app);

$app->run();
