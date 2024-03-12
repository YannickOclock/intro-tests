<?php
    namespace Mvc\Fixtures;

    use Mvc\Utils\Database;
    use Symfony\Component\Dotenv\Dotenv;

    class AppFixtures {

        protected array $objectSet = [];
        protected array $tableObjects = [];

        public function __construct() {
            // On charge les variables d'environnement (pour les tests sur la machine locale)
            // Pour le Github actions, les variables seront définies dans le contexte d'exécution
            $dotenv = new Dotenv();
            if(file_exists(__DIR__ . '/../../.env')) {
                $dotenv->load(__DIR__ . '/../../.env');
            }
        }

        public function initTableObjects() {
            $aliceFolder = __DIR__ . '/fixtures';
            $loader = new AppNativeLoader();
            $this->objectSet = $loader->loadFiles([$aliceFolder . '/posts.yaml'])->getObjects();
            foreach($this->objectSet as $object) {
                $tableName = $object->getClass();
                $this->tableObjects[] = $tableName;
            }
        }
        public function load() {
            $pdo = Database::getPdo();
            $this->initTableObjects();
            foreach($this->objectSet as $object) {
                $tableName = $object->getClass();
                $data = $object->getProperties();
                $this->tableObjects[] = $tableName;
                $columns = implode(', ', array_keys($data));
                $values = array_map(function ($value) {
                    return is_string($value) ? "'$value'" : $value;
                }, array_values($data));
                $values = implode(', ', $values);
                $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
                $pdo->exec($sql);
            }
        }

        public function unload() {
            $pdo = Database::getPdo();
            $this->initTableObjects();
            foreach($this->tableObjects as $tableName) {
                $pdo->exec("DELETE FROM $tableName");
            }
        }

        public function truncate() {
            $pdo = Database::getPdo();
            $this->initTableObjects();
            foreach($this->tableObjects as $tableName) {
                $pdo->exec("TRUNCATE TABLE $tableName");
            }
        }
    }