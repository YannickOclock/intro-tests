<?php

use Mvc\Models\PostModel;
use function DI\create;

return [
    // Bind PostModel to its class
    PostModel::class => create(),

    AltoRouter::class => function () {
        $router = new AltoRouter();
        if (array_key_exists('BASE_URI', $_SERVER)) {
            $router->setBasePath($_SERVER['BASE_URI']);
        } else {
            $_SERVER['BASE_URI'] = '/';
        }
        return $router;
    },
];