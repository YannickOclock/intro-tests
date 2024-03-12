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

    }