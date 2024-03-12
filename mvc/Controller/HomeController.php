<?php
    namespace Mvc\Controller;

    use Mvc\Utils\HtmlResponse;

    class HomeController extends AbstractViewController
    {
        public function index(): HtmlResponse
        {
            return $this->show('home');
        }
    }