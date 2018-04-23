<?php

namespace MakeWeb\TestServer;

class TestServer
{
    public $routes;

    public function __construct()
    {
        $this->routes = collect();
    }

    public function withRoute($method, $uri, $callback)
    {
        $this->routes->push(new Route($method, $uri, $callback));

        return $this;
    }

    public function start()
    {
        $testServerPort = !empty(getenv('TEST_SERVER_PORT')) ? getenv('TEST_SERVER_PORT') : '8000';

        $url = "localhost:$testServerPort";

        $pid = exec('ROUTES="'.base64_encode(serialize($this->routes)).'" php -d variables_order=EGPCS -S '.$url.' -t '.__DIR__.'/server/public > /dev/null 2>&1 & echo $!');

        while (@file_get_contents('http://'.$url.'/exit') === false) {
            usleep(1000);
        }
        register_shutdown_function(function () use ($pid) {
            exec('kill '.$pid);
        });
    }
}
