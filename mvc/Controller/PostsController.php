<?php
    namespace Mvc\Controller;

    use Mvc\Models\PostModel;
    use Mvc\Utils\HtmlResponse;

    class PostsController extends AbstractViewController {

        public function showPosts(PostModel $postModel): HtmlResponse
        {
            return $this->show('posts/index',
                [
                    'posts' => $postModel->findAll()
                ]
            );
        }

        public function showPostsAsync(): HtmlResponse
        {
            // Les posts seront affichés via JavaScript
            return $this->show('posts/async');
        }

        public function showAddForm(): HtmlResponse
        {
            return $this->show('posts/add');
        }

        public function submitAddForm(): HtmlResponse
        {
            $errorList = [];

            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $author = $_POST['author'] ?? '';

            if (empty($title)) {
                $errorList[] = 'Le titre est obligatoire';
            }
            if(strlen($title) < 3 || strlen($title) > 255) {
                $errorList[] = 'Le titre doit contenir entre 3 et 255 caractères';
            }

            if (empty($content)) {
                $errorList[] = 'Le contenu est obligatoire';
            }
            if(strlen($content) < 3) {
                $errorList[] = 'Le contenu doit contenir au moins 3 caractères';
            }

            if (empty($author)) {
                $errorList[] = 'L\'auteur est obligatoire';
            }
            if(strlen($author) < 3 || strlen($author) > 100) {
                $errorList[] = 'L\'auteur doit contenir entre 3 et 100 caractères';
            }

            if (empty($errorList)) {
                $postModel = new PostModel();
                $postModel->setTitle($title)
                    ->setContent($content)
                    ->setAuthor($author)
                    ->setDate(date('Y-m-d H:i:s'));

                try {
                    $postModel->save();
                } catch (\Exception $e) {
                    $errorList[] = $e->getMessage();
                }

                $this->addFlashMessage('Le post a bien été ajouté');
                return $this->showPosts($postModel);
            }

            return $this->show('posts/add', ['errorList' => $errorList], 400);
        }

    }