<?php

namespace Mvc\Utils;

class Response
{
    private string $content = '';
    private array $headers = [];
    public function __construct()
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function addContent(string $content): void
    {
        $this->content .= $content;
    }

    public function setHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->setHeader("HTTP/2.0 $statusCode");
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

    public function send(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->content;
    }
}