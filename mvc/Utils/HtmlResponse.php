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
        // TODO : $htmlObject->loadHTML($html->getContent(), LIBXML_NOERROR) =>
        // TODO : il faudrait mettre des str_replace pour les balises sémantiques (article, header, etc.),
        // TODO : puis enlever le LIBXML_NOERROR
        // TODO : stackoverflow.com/questions/6090667/php-domdocument-errors-warnings-on-html5-tags

        ob_start();
        extract($this->data, EXTR_SKIP);
        foreach ($this->views as $view) {
            include $view;
        }
        return ob_get_clean();
    }

    public function getFlashMessages(): array
    {
        return $_SESSION['flashMessages'] ?? [];
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