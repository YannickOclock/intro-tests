<?php

namespace Mvc\Controller;

use Mvc\Models\PostModel;
use Mvc\Utils\JsonResponse;

class PostsApiController
{
    public function showApiPosts(PostModel $postModel): JsonResponse
    {
        // Rechercher tous les posts et transformer les posts en tableau
        // Plus tard, on pourra utiliser une classe de transformation (serializer)
        $jsonPosts = array_map(function($post) {
            return [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'author' => $post->getAuthor(),
                'date' => $post->getDate()
            ];
        }, $postModel->findAll());

        return new JsonResponse([
            'posts' => $jsonPosts
        ]);
    }
}