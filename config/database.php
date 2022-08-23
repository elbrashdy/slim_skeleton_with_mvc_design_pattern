<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// Make sure you write correct configuration for this

$dbConfig = [
    'driver' => 'mysql',
    'host'=>'localhost',
    'database'=>'slim',
    'username'=>'root',
    'password'=>'',
    'charset'=>'utf8',
    'collation'=>'utf8_unicode_ci',
    'prefix'=>''
];

$capsule = new Capsule();
$capsule->addConnection($dbConfig);
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
