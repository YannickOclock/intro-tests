<?php

    namespace Mvc\Fixtures;

    use Mvc\Utils\Database;
    use Symfony\Component\Dotenv\Dotenv;

    class AppMigrations {

        public function __construct() {
            // On charge les variables d'environnement (pour les tests sur la machine locale)
            // Pour le Github actions, les variables seront définies dans le contexte d'exécution
            $dotenv = new Dotenv();
            if(file_exists(__DIR__ . '/../../../.env')) {
                $dotenv->load(__DIR__ . '/../../../.env');
            }
        }

        public function migrate() {
            $pdo = Database::getPdo();

            // create table for migrations
            $pdo->exec('CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)');

            // read all migrations files
            $migrationsFolder = __DIR__ . '/../../migrations';
            $migrationsFiles = scandir($migrationsFolder);
            foreach($migrationsFiles as $file) {
                if($file === '.' || $file === '..') {
                    continue;
                }

                // check if migration has already been executed
                $result = $pdo->query("SELECT migration FROM migrations WHERE migration = '$file'");
                if($result->fetch()) {
                    continue;
                }

                // execute migration
                $sql = file_get_contents($migrationsFolder . '/' . $file);

                // store migration in migrations table
                $pdo->exec("INSERT INTO migrations (migration) VALUES ('$file')");

                $pdo->exec($sql);
            }

        }
    }