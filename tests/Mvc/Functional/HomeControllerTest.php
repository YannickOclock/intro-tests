<?php

    namespace Tests\Mvc\Functional;

    use DOMDocument;
    use Mvc\Controller\HomeController;
    use Mvc\Models\PostModel;
    use PHPUnit\Framework\MockObject\Exception;
    use PHPUnit\Framework\TestCase;
    use Symfony\Component\DomCrawler\Crawler;

    class HomeControllerTest extends TestCase {

        public function assertRegExp(string $pattern, string $string, string $message = ''): void {
            $this->assertMatchesRegularExpression($pattern, $string, $message);
        }
        public function testIndex(): void
        {
            $controller = new HomeController();
            $html = $controller->index();

            // Est-ce que le document HTML contient un titre h1 ? (on utilise une expression régulière)
            $htmlObject = new DOMDocument();
            $htmlObject->loadHTML($html->getContent());
            $htmlCrawler = new Crawler($htmlObject);

            $this->assertEquals(200, $html->getStatusCode());
            $this->assertEquals(1, $htmlCrawler->filter('h1')->count());
            $this->assertRegExp('/Page d\'accueil/', $htmlCrawler->filter('h1')->text());
        }

        /**
         * @throws Exception
         */
        public function testShowPosts(): void
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
            $html = $controller->showPosts($postModel);

            $htmlObject = new DOMDocument();
            $htmlObject->loadHTML($html->getContent());
            $htmlCrawler = new Crawler($htmlObject);

            $this->assertEquals(200, $html->getStatusCode());
            $this->assertEquals(3, $htmlCrawler->filter('article')->count());
        }
    }