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

        $pattern = $this->path;
        $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);
        $pattern = '#^'.$pattern.'$#';

        $result = preg_match($pattern, $request->getPathInfo(), $matches);

        if (!$result || $matches[0] != $request->getPathInfo()) {
            return false;
        }

        return true;

    }

    public function getResponse(Request $request): Response
    {
        $pattern = $this->path;
        $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);
        $pattern = '#^'.$pattern.'$#';

        $result = preg_match($pattern, $request->getPathInfo(), $matches);

        preg_match_all('/{(.*?)}/', $this->path, $paramKeyMatches);

        $paramKeys = isset($paramKeyMatches[1]) ? $paramKeyMatches[1] : [];
        $paramValues = $matches;
        unset($paramValues[0]);
        $paramValues = array_values($paramValues);

        $params = [
            'request' => $request,
        ];

        foreach($paramKeys as $index => $paramKey) {
            $params[$paramKey] = $paramValues[$index];
        }

        $response = call_user_func_array($this->callable, $params);

        if ($response instanceof Response) {
            return $response;
        }

        return new Response($response, 200);
    }
}