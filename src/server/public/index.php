<?php

require_once __DIR__.'/../../../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$routes = unserialize(base64_decode($_ENV['ROUTES']));

foreach ($routes as $route) {
    $app->router->{$route->method}($route->uri, function () use ($route) {
        return $route->getCallback()(app('request'));
    });
}

$app->router->get('/exit', function () {
    return response('exit');
});

$app->run();
