<?php

namespace DivineOmega\OverflowFramework\Http;

class Response
{
    private $body;
    private $status;

    public function __construct(string $body, int $status)
    {
        $this->body = $body;
        $this->status = $status;
    }

    public function output()
    {
        http_response_code($this->status);
        echo $this->body;
    }
}