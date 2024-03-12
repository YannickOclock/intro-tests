<?php
    namespace Mvc\Controller;

    use Mvc\Exceptions\InvalidPostDataException;
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

        public function submitAddForm(): ?HtmlResponse
        {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $author = $_POST['author'] ?? '';

            $postModel = new PostModel();
            $postModel->setTitle($title)
                ->setContent($content)
                ->setAuthor($author)
                ->setDate(date('Y-m-d H:i:s'));

            try {
                $postModel->validate();
                $postModel->save();
            } catch (InvalidPostDataException $e) {
                $errorList = $e->getErrors();
            } catch (\Exception $e) {
                $errorList[] = $e->getMessage();
            }

            if (empty($errorList)) {
                $this->addFlashMessage('Le post a bien été ajouté');
                $this->redirect('posts');
            }


            return $this->show('posts/add', ['errorList' => $errorList], 400);
        }

    }