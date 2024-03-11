<?php
    namespace Mvc\Utils;

    use PDO;

    class Database
    {
        private PDO $pdo;

        public function __construct()
        {
            if($_ENV['APP_ENV'] === 'testing') {
                $this->pdo = new PDO('mysql:host=' . $_ENV['DB_TEST_HOST'] . '; dbname=' . $_ENV['DB_TEST_NAME'],
                    $_ENV['DB_TEST_USERNAME'],
                    $_ENV['DB_TEST_PASSWORD']
                );
            } else {
                $this->pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . '; dbname=' . $_ENV['DB_NAME'],
                    $_ENV['DB_USERNAME'],
                    $_ENV['DB_PASSWORD']
                );
            }
        }

        public static function getPdo(): PDO
        {
            static $instance = null;
            if ($instance === null) {
                $instance = new Database();
            }
            return $instance->pdo;
        }
    }