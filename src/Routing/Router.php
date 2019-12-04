<?php

namespace DivineOmega\OverflowFramework\Routing;

use DivineOmega\OverflowFramework\Http\Request;
use DivineOmega\OverflowFramework\Http\Response;

class Router
{
    private $routes = [];

    private function validateMethod(string $method)
    {
        return in_array($method, [
            'GET',
            'POST',
            'PATCH',
            'DELETE',
        ]);
    }

    public function addRoute(string $method, string $uri, callable $callable): Route
    {
        if (!$this->validateMethod($method)) {
            throw new \InvalidArgumentException('Invalid method.');
        }

        $route = new Route($method, $uri, $callable);
        $this->routes[] = $route;

        return $route;
    }

    private function getMatchingRoute(Request $request)
    {
        foreach($this->routes as $route) {
            if ($route->matches($request)) {
                return $route;
            }
        }

        return null;
    }

    public function route(Request $request)
    {
        $route = $this->getMatchingRoute($request);

        if (!$route) {
            return new Response('Page not found', 404);
        }

        return $route->getResponse();
    }
}