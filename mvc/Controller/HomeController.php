<?php
    namespace Mvc\Controller;

    class HomeController
    {
        public function index(): void
        {
            $this->show('home');
        }

        public function show($viewName, $data = []): void
        {
            extract($data);
            require_once __DIR__ . "/../Views/parts/header.tpl.php";
            require_once __DIR__ . "/../Views/pages/$viewName.tpl.php";
            require_once __DIR__ . "/../Views/parts/footer.tpl.php";
        }
    }