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

        public function testShowAsyncPostsPage()
        {
            // PROBLEME : le test peut ne pas passer car on utilise des données de la base de PRODUCTION
            // SOLUTION : il faudrait utiliser des fixtures et une base de données de TEST

            $client = static::createPantherClient();

            $client->request('GET', '/posts-async');
            $client->waitFor('article');

            $posts = $client->getCrawler()->filter('article');
            $this->assertCount(2, $posts);
        }
    }