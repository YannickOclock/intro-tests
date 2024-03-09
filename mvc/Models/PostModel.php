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

        public function findAll(): array
        {
            $pdo = Database::getPdo();
            $statement = $pdo->prepare('SELECT * FROM posts');
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, self::class);
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