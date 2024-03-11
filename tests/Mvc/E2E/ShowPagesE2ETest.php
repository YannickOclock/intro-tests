<?php
    namespace Tests\Mvc\E2E;

    use Mvc\Fixtures\AppFixtures;
    use Mvc\Fixtures\AppMigrations;
    use Mvc\Utils\Database;
    use PDO;
    use Symfony\Component\Dotenv\Dotenv;
    use Symfony\Component\Panther\PantherTestCase;

    class ShowPagesE2ETest extends PantherTestCase
    {
        private AppFixtures $fixtures;
        public function setUp(): void
        {
            parent::setUp(); // TODO: Change the autogenerated stub

            // load fixtures
            $this->fixtures = new AppFixtures();
            $this->fixtures->load();

            $pdo = Database::getPdo();
            // dump data

            $posts = $pdo->query('SELECT * FROM posts')->fetchAll(PDO::FETCH_ASSOC);
            var_dump($posts);
        }

        public function tearDown(): void
        {
            parent::tearDown(); // TODO: Change the autogenerated stub
            $this->fixtures->unload();
        }

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
            $client->waitFor('article', 30);

            $posts = $client->getCrawler()->filter('article');
            $this->assertCount(5, $posts);
        }
    }