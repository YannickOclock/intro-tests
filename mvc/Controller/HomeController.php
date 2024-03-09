<?php
    namespace Mvc\Controller;

    use Mvc\Models\PostModel;
    use Mvc\Utils\JsonResponse;
    use Mvc\Utils\HtmlResponse;

    readonly class HomeController
    {
        public function __construct()
        {
        }

        public function index(): HtmlResponse
        {
            return $this->show('home');
        }

        public function showPosts(PostModel $postModel): HtmlResponse
        {
            return $this->show('posts/index',
                [
                    'posts' => $postModel->findAll()
                ]
            );
        }

        public function showApiPosts(PostModel $postModel): JsonResponse
        {
            // Rechercher tous les posts et transformer les posts en tableau
            // Plus tard, on pourra utiliser une classe de transformation (serializer)
            $jsonPosts = array_map(function($post) {
                return [
                    'id' => $post->getId(),
                    'title' => $post->getTitle(),
                    'content' => $post->getContent(),
                    'author' => $post->getAuthor(),
                    'date' => $post->getDate()
                ];
            }, $postModel->findAll());

            return new JsonResponse([
                'posts' => $jsonPosts
            ]);
        }

        public function showPostsAsync(PostModel $postModel): HtmlResponse
        {
            // Les posts seront affichés via JavaScript
            return $this->show('posts/async');
        }

        public function show($viewName, $data = []): HtmlResponse
        {
            $response = new HtmlResponse();
            $response->addHeader('Content-Type: text/html; charset=utf-8');
            $response->setStatusCode(200);
            $response->addData($data);
            $response->addView(__DIR__ . "/../Views/parts/header.tpl.php");
            $response->addView(__DIR__ . "/../Views/pages/$viewName.tpl.php");
            $response->addView(__DIR__ . "/../Views/parts/footer.tpl.php");
            return $response;
        }
    }