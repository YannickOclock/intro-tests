<?php
    namespace Mvc\Utils;

    class JsonResponse extends AbstractResponse
    {
        public function __construct(private array $content = [], int $statusCode = 200, array $headers = [])
        {
            parent::__construct();
            $this->addHeader('Content-Type: application/json; charset=utf-8');
            $this->setStatusCode($statusCode);
            foreach ($headers as $header) {
                $this->addHeader($header);
            }
        }

        public function addContent(array $content): void
        {
            $this->content = array_merge($this->content, $content);
        }

        public function addError($message): void
        {
            $this->addHeader('HTTP/2.0 500');
            $this->content = array_merge([], ['error' => $message]);
        }

        public function addSuccess($message): void
        {
            $this->addHeader('HTTP/2.0 200');
            $this->content = array_merge($this->content, ['success' => $message]);
        }

        public function getContent(): array
        {
            return $this->content;
        }

        public function send(): void
        {
            foreach ($this->headers as $header) {
                header($header);
            }
            echo json_encode($this->content);
        }
    }