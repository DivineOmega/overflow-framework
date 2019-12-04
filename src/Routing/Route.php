<?php

namespace DivineOmega\OverflowFramework\Routing;

use DivineOmega\OverflowFramework\Http\Request;
use DivineOmega\OverflowFramework\Http\Response;

class Route
{
    private $method;
    private $uri;
    private $callable;

    public function __construct(string $method, string $uri, callable $callable)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->callable = $callable;
    }

    public function matches(Request $request)
    {
        if ($this->method !== $request->method) {
            return false;
        }

        if ($this->uri !== $request->uri) {
            return false;
        }

        return true;

    }

    public function getResponse(): Response
    {
        return new Response(call_user_func($this->callable), 200);
    }
}