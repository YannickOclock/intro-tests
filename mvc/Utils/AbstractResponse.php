<?php

namespace Mvc\Utils;

class AbstractResponse
{
    protected array $headers = [];
    public function __construct()
    {
    }

    public function addHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->addHeader("HTTP/2.0 $statusCode");
    }

    public function getStatusCode(): int
    {
        // On cherche le header contenant le status code
        foreach ($this->headers as $header) {
            if (preg_match('/HTTP\/2.0 (\d+)/', $header, $matches)) {
                return (int)$matches[1];
            }
        }
    }
}