<?php

namespace MakeWeb\TestServer;

use SuperClosure\Serializer;

class Route
{
    public $method;

    public $uri;

    public $callback;

    public function __construct($method, $uri, $callback)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->setCallback($callback);
    }

    public function setCallback($callback)
    {
        $this->callback = (new Serializer())->serialize($callback);
    }

    public function getCallback()
    {
        return (new Serializer())->unserialize($this->callback);
    }
}
