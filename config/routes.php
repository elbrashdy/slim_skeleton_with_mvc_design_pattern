<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\HomeController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) { 

   // Authenticating User

   $app->group("/auth", function ($app) {
      $app->post('/login', [AuthController::class, 'login']);
      $app->post('/register', [AuthController::class, 'register']);
   });

   $app->options('/auth/login', function (Request $request, Response $response): Response {
      return $response;
   });

   $app->options('/auth/register', function (Request $request, Response $response): Response {
      return $response;
   });

   // Protected routes

   $app->get('/', [HomeController::class, 'index']);
   $app->post('/', [HomeController::class, 'create']);
   $app->options('/', function (Request $request, Response $response): Response {
      return $response;
   });

};
