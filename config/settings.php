<?php

use DI\Container;
use Psr\Container\ContainerInterface;

return function(Container $container) {
    $container->set('settings', function(){
        $db = require_once __DIR__ . '/database.php';
        return [
            'db' => $db
        ];
    });
}; 
