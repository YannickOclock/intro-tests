<?php
    namespace Mvc\Utils;

    use PDO;

    class Database
    {
        private PDO $pdo;

        public function __construct()
        {
            $ini_file = parse_ini_file(__DIR__ . '/../config.ini');
            $this->pdo = new PDO('mysql:host='. $ini_file['dbhost'] .'; dbname=' . $ini_file['dbname'], $ini_file['dbusername'], $ini_file['dbpassword']);
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