<?php

    namespace Mvc\Api;

    use Mvc\Controller\HomeController;
    use Mvc\Models\PostModel;
    use PHPUnit\Framework\MockObject\Exception;
    use PHPUnit\Framework\TestCase;

    class ApiPostsTest extends TestCase {

        /**
         * @throws Exception
         */
        public function testShowApiPosts(): void
        {
            // Creation d'un mock de PostModel
            $postModel = $this->createMock(PostModel::class);
            $postModel->method('findAll')->willReturn([
                (new PostModel())->setId(1)->setTitle('Titre 1')->setContent('Contenu 1')->setAuthor('Auteur 1')->setDate('2021-01-01'),
                (new PostModel())->setId(2)->setTitle('Titre 2')->setContent('Contenu 2')->setAuthor('Auteur 2')->setDate('2021-01-02'),
                (new PostModel())->setId(3)->setTitle('Titre 3')->setContent('Contenu 3')->setAuthor('Auteur 3')->setDate('2021-01-03')
            ]);

            // Test du controller avec le mock
            $controller = new HomeController();
            $json = $controller->showApiPosts($postModel);

            $this->assertEquals(200, $json->getStatusCode());
            $this->assertEquals(3, count($json->getContent()['posts']));
        }
    }