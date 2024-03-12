<?php
    namespace Mvc\Models;

    use Assert\LazyAssertionException;
    use Mvc\Exceptions\InvalidPostDataException;
    use Mvc\Utils\Database;
    use PDO;
    use function Assert\lazy;

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

        /**
         * @throws InvalidPostDataException
         */
        public function validate(): void
        {
            try {
                // validate with beberlei/assert
                lazy()
                    ->tryAll()
                    ->that($this->title, 'title')
                        ->string("Le titre doit être une chaine de caractères")
                        ->notEmpty("Le titre ne doit pas être vide")
                        ->minLength(3, "Le titre doit contenir au moins 3 caractères")
                        ->maxLength(255, "Le titre doit contenir au maximum 255 caractères")
                    ->that($this->content, 'content')
                        ->string("Le contenu doit être une chaine de caractères")
                        ->notEmpty("Le contenu ne doit pas être vide")
                        ->minLength(3, "Le contenu doit contenir au moins 3 caractères")
                    ->that($this->author, 'author')
                        ->string("L'auteur doit être une chaine de caractères")
                        ->notEmpty("L'auteur ne doit pas être vide")
                        ->minLength(3, "L'auteur doit contenir au moins 3 caractères")
                        ->maxLength(100, "L'auteur doit contenir au maximum 100 caractères")
                    ->that($this->date, 'date')
                        ->string("La date doit être une chaine de caractères")
                        ->notEmpty("La date ne doit pas être vide")
                    ->verifyNow();
            } catch (LazyAssertionException $e) {
                throw InvalidPostDataException::withErrors($e->getErrorExceptions());
            }
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
                $sql = 'INSERT INTO ' . $this->getClass() . '(`title`, `content`, `author`, `date`) VALUES (:title, :content, :author, :date)';
                $statement = $pdo->prepare($sql);
                $statement->execute([
                    'title' => $this->title,
                    'content' => $this->content,
                    'author' => $this->author,
                    'date' => $this->date
                ]);
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