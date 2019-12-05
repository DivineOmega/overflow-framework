<?php

namespace DivineOmega\OverflowFramework\Routing;

use DivineOmega\OverflowFramework\Http\Request;
use DivineOmega\OverflowFramework\Http\Response;

class Route
{
    private $method;
    private $path;
    private $callable;

    public function __construct(string $method, string $path, callable $callable)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callable = $callable;
    }

    public function matches(Request $request)
    {
        if ($this->method !== $request->getMethod()) {
            return false;
        }

        if ($this->path !== $request->getPathInfo()) {
            return false;
        }

        return true;

    }

    public function getResponse(Request $request): Response
    {
        $response = call_user_func($this->callable, $request);

        if ($response instanceof Response) {
            return $response;
        }

        return new Response($response, 200);
    }
}