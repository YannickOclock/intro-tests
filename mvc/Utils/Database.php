<?php
    namespace Mvc\Utils;

    use PDO;

    class Database
    {
        private PDO $pdo;
        static private $instance = null;

        /**
         * @throws \Exception
         */
        public function __construct()
        {
            try {
                if ($_ENV['APP_ENV'] === 'testing') {
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
            } catch (\Exception $e) {
                throw new \Exception('Impossible de se connecter à la base de données');
            }
        }

        static public function getPdo(): PDO
        {
            $instance = self::$instance;
            if ($instance === null) {
                $instance = new Database();
            }
            return $instance->pdo;
        }

        static public function destruct(): void
        {
            self::$instance = null;
        }

        public function __destruct()
        {
            self::destruct();
        }
    }