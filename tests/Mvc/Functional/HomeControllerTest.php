<?php

    namespace Tests\Mvc\Functional;

    use DOMDocument;
    use Mvc\Controller\HomeController;
    use PHPUnit\Framework\TestCase;
    use Symfony\Component\BrowserKit\HttpBrowser;
    use Symfony\Component\DomCrawler\Crawler;
    use Symfony\Component\HttpClient\HttpClient;

    class HomeControllerTest extends TestCase {

        public function assertRegExp(string $pattern, string $string, string $message = ''): void {
            $this->assertMatchesRegularExpression($pattern, $string, $message);
        }
        public function testIndex(): void
        {
            $httpClient = HttpClient::create();
            $browser = new HttpBrowser($httpClient);
            $crawler = $browser->request('GET', '/');
            $this->assertRegExp('/Page d\'accueil/', $crawler->filter('h1')->text());
        }
    }