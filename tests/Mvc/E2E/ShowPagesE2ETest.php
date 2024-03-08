<?php
    namespace Tests\Mvc\E2E;

    use Symfony\Component\Panther\PantherTestCase;

    class ShowPagesE2ETest extends PantherTestCase
    {
        public function testShowHomePage()
        {
            $client = static::createPantherClient();
            $client->request('GET', '/');

            $client->waitFor('h1');

            $h1 = $client->getCrawler()->filter('h1')->text();
            $this->assertSame('Page d\'accueil', $h1);
        }
    }