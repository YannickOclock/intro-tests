<?php
    namespace Tests\Mvc\App;

    use Mvc\Fixtures\AppFixtures;
    use Mvc\Fixtures\AppMigrations;
    use PHPUnit\Framework\TestCase;

    class AppMigrationsTest extends TestCase
    {
        public function __setUp(): void
        {
            // Supprime toutes les tables s'il en existe (avant de lancer la migration)
            $appFixtures = new AppFixtures();
            $appFixtures->truncate();
        }
        public function testMigrate()
        {
            $appMigrations = new AppMigrations();
            $appMigrations->truncate();
            $appMigrations->migrate();
            $this->assertTrue(true);
        }
        public function testTruncateFixtures()
        {
            $appFixtures = new AppFixtures();
            $appFixtures->truncate();
            $this->assertTrue(true);
        }
        public function testLoadMigrationsWithDefinedData()
        {
            $appMigrations = new AppMigrations();
            $appMigrations->migrate();

            $appFixtures = new AppFixtures();
            $appFixtures->load();

            $appMigrations = new AppMigrations();
            $appMigrations->migrate();

            $this->assertTrue(true);
        }
    }