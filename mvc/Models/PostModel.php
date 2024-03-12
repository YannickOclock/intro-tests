<?php
    namespace Mvc\Models;

    use Mvc\Utils\Database;
    use PDO;

    class PostModel
    {
        private int $id;
        private string $title;
        private string $content;
        private string $author;
        private string $date;

        public function __construct()
        {
        }

        public function getClass(): string
        {
            return 'posts';
        }
        public function getProperties(): array
        {
            return [
                'title' => $this->title,
                'content' => $this->content,
                'author' => $this->author,
                'date' => $this->date
            ];
        }

        public function findAll(): array
        {
            $pdo = Database::getPdo();
            $statement = $pdo->prepare('SELECT * FROM posts');
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
        }

        /**
         * @throws \Exception
         */
        public function save(): int
        {
            try {
                $pdo = Database::getPdo();
                $properties = $this->getProperties();
                $columns = array_keys($properties);
                $sql = 'INSERT INTO ' . $this->getClass() . ' (' . implode(', ', $columns) . ') VALUES (:' . implode(', :', $columns) . ')';
                $statement = $pdo->prepare($sql);
                $statement->execute($properties);
            } catch (\Exception $e) {
                throw new \Exception('Erreur lors de l\'insertion d\'un post : ' . $e->getMessage());
            }

            $this->id = $pdo->lastInsertId();
            return $this->id;
        }

        public function setTitle(string $title): PostModel
        {
            $this->title = $title;
            return $this;
        }

        public function setContent(string $content): PostModel
        {
            $this->content = $content;
            return $this;
        }

        public function setAuthor(string $author): PostModel
        {
            $this->author = $author;
            return $this;
        }

        public function setDate(string $date): PostModel
        {
            $this->date = $date;
            return $this;
        }

        public function setId(int $id): PostModel
        {
            $this->id = $id;
            return $this;
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getTitle(): string
        {
            return $this->title;
        }

        public function getContent(): string
        {
            return $this->content;
        }

        public function getAuthor(): string
        {
            return $this->author;
        }

        public function getDate(): string
        {
            return $this->date;
        }
    }