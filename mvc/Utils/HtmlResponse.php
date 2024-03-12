<?php

namespace Mvc\Utils;

class HtmlResponse extends AbstractResponse
{
    public string $htmlContent = '';
    private array $views = [];
    private array $data = [];
    public function __construct()
    {
        parent::__construct();
    }

    public function getContent(): string
    {
        ob_start();
        extract($this->data, EXTR_SKIP);
        foreach ($this->views as $view) {
            include $view;
        }
        return ob_get_clean();
    }

    public function addHtmlContent($htmlContent = ''): void
    {
        $this->htmlContent = $htmlContent;
    }

    public function addView($viewPath): void
    {
        $this->views[] = $viewPath;
    }

    public function addData(array $data): void
    {
        $this->data = array_merge($this->data, $data);
    }

    public function send(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }
        extract($this->data, EXTR_SKIP);
        foreach($this->views as $view) {
            include $view;
        }
        echo $this->htmlContent;
    }
}