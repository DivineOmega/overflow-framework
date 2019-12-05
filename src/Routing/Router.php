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

    public function addRoute(string $method, string $path, callable $callable): Route
    {
        if (!$this->validateMethod($method)) {
            throw new \InvalidArgumentException('Invalid method.');
        }

        $route = new Route($method, $path, $callable);
        $this->routes[] = $route;

        return $route;
    }

    public function get(string $path, callable $callable): Route
    {
        return $this->addRoute('GET', $path, $callable);
    }

    public function post(string $path, callable $callable): Route
    {
        return $this->addRoute('POST', $path, $callable);
    }

    public function patch(string $path, callable $callable): Route
    {
        return $this->addRoute('PATCH', $path, $callable);
    }

    public function delete(string $path, callable $callable): Route
    {
        return $this->addRoute('DELETE', $path, $callable);
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

        return $route->getResponse($request);
    }
}