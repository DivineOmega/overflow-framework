<?php

namespace DivineOmega\OverflowFramework\Http;

class Request
{
    public $method;
    public $uri;
    public $data;

    public function __construct(string $method, string $uri, array $data)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->data = $data;
    }

    public static function buildFromCurrentRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $data = $_REQUEST;

        return new self($method, $uri, $data);
    }
}