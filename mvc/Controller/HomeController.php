<?php
    namespace Mvc\Controller;

    use Mvc\Models\PostModel;
    use Mvc\Utils\Response;

    readonly class HomeController
    {
        public function __construct()
        {
        }

        public function index(): Response
        {
            return $this->show('home');
        }

        public function showPosts(PostModel $postModel): Response
        {
            return $this->show('posts/index',
                [
                    'posts' => $postModel->findAll()
                ]
            );
        }

        public function show($viewName, $data = []): Response
        {
            $response = new Response();
            $response->setHeader('Content-Type: text/html; charset=utf-8');
            $response->setStatusCode(200);
            $response->addData($data);
            $response->addView(__DIR__ . "/../Views/parts/header.tpl.php");
            $response->addView(__DIR__ . "/../Views/pages/$viewName.tpl.php");
            $response->addView(__DIR__ . "/../Views/parts/footer.tpl.php");
            return $response;
        }
    }