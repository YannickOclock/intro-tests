<?php

    namespace Tests\Mvc\Functional;

    use DOMDocument;
    use Mvc\Controller\HomeController;
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
    }