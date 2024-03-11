<?php

    // script pour créer la base de données de test

    use Symfony\Component\Dotenv\Dotenv;

    require_once __DIR__ . '/vendor/autoload.php';

    class Command {
        public function __construct() {
            // On charge les variables d'environnement (pour les tests sur la machine locale)
            // Pour le Github actions, les variables seront définies dans le contexte d'exécution
            $dotenv = new Dotenv();
            if(file_exists(__DIR__ . '/.env')) {
                $dotenv->load(__DIR__ . '/.env');
            }
        }

        public function runMigrations() {
            $appMigration = new Mvc\Fixtures\AppMigrations();
            $appMigration->migrate();
            echo "Migrations done\n";
        }

        public function loadFixtures() {
            $appFixtures = new Mvc\Fixtures\AppFixtures();
            $appFixtures->truncate();
            $appFixtures->load();
            echo "Fixtures loaded\n";
        }
    }

    $command = new Command();

    // get argv
    $argv = $_SERVER['argv'];

    // option version
    if(count($argv) === 2 && $argv[1] === '--version') {
        echo "1.0.0\n";
        exit(0);
    }

    if($argv[1] === 'migrate') {
        $command->runMigrations();
    } else if($argv[1] === 'fixtures') {
        $command->loadFixtures();
    } else {
        echo "Usage: php command.php [migrate|fixtures]\n";
        exit(1);
    }


