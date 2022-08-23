<?php

use Slim\App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface as Response;

// for JWT_SECRETE_KEY write a strong random number

const JWT_SECRETE_KEY = "this_should_not_committed_to_github";

return function (App $app) {
    $app->getContainer()->get('settings');

    $app->add(new Tuupola\Middleware\JwtAuthentication([
        // Add All public routes on the ignore array
        "ignore" => [
            '/auth/login',
        ],
        "secret" => JWT_SECRETE_KEY,
        "credentials" => true,
        "error" => function ($response, $arguments) {
            $data["success"] = false;
            $data["response"] = $arguments["message"];
            $data["status_code"] = "401";

            $response->getBody()->write(
                json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            );

            return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        }
    ]));


    $app->addBodyParsingMiddleware();

    $app->add(function (Request $request, RequestHandlerInterface $handler): Response {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');
    
        $response = $handler->handle($request);
    
        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
    
        return $response;
    });
    $app->addRoutingMiddleware();

    $app->addErrorMiddleware(true, true, true);
};
