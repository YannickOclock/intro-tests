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
        public function testIndex() {
            ob_start();

            $controller = new HomeController();
            $controller->index();

            // Est-ce que le document HTML contient un titre h1 ? (on utilise une expression régulière)
            $html = ob_get_clean();
            $htmlObject = new DOMDocument();
            $htmlObject->loadHTML($html);
            $htmlCrawler = new Crawler($htmlObject);
            $this->assertEquals(1, $htmlCrawler->filter('h1')->count());
            $this->assertRegExp('/Page d\'accueil/', $htmlCrawler->filter('h1')->text());
        }
    }