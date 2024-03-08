<?php
    namespace Mvc\Controller;

    use Mvc\Utils\Response;

    class HomeController
    {
        public function index(): Response
        {
            return $this->show('home');
        }

        public function show($viewName, $data = []): Response
        {
            extract($data);
            $response = new Response();
            $response->setHeader('Content-Type: text/html; charset=utf-8');
            $response->setStatusCode(200);
            $response->addView(__DIR__ . "/../Views/parts/header.tpl.php");
            $response->addView(__DIR__ . "/../Views/pages/$viewName.tpl.php");
            $response->addView(__DIR__ . "/../Views/parts/footer.tpl.php");
            return $response;
        }
    }