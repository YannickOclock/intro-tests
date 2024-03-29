<?php

    // Un exemple d'utilisation de la classe

    require_once __DIR__ . '/../vendor/autoload.php';

    use DI\ContainerBuilder;
    use Mvc\Controller\HomeController;
    use Mvc\Controller\PostsApiController;
    use Mvc\Controller\PostsController;
    use Symfony\Component\Dotenv\Dotenv;

    session_start();

    $container = null;

    // Création du container
    $containerBuilder = new ContainerBuilder();
    $containerBuilder->addDefinitions(__DIR__ . '/config.php');
    try {
        $container = $containerBuilder->build();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    // Chargement des variables d'environnement
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/../.env');

    // Instanciation d'un mini routeur

    $altorouter = new AltoRouter();
    $altorouter->map('GET', '/', [
        'method' => 'index',
        'controller' => HomeController::class
    ]);
    $altorouter->map('GET', '/posts', [
        'method' => 'showPosts',
        'controller' => PostsController::class
    ]);
    // show posts with async await fetch
    $altorouter->map('GET', '/posts-async', [
        'method' => 'showPostsAsync',
        'controller' => PostsController::class
    ]);
    $altorouter->map('GET', '/api/posts', [
        'method' => 'showApiPosts',
        'controller' => PostsApiController::class
    ]);
    $altorouter->map('GET', '/posts/add', [
        'method' => 'showAddForm',
        'controller' => PostsController::class
    ]);
    $altorouter->map('POST', '/posts/add', [
        'method' => 'submitAddForm',
        'controller' => PostsController::class
    ]);

    $match = $altorouter->match();
    if ($match) {
        $controllerName = $match['target']['controller'];
        $method = $match['target']['method'];

        // Transformation du nom de la classe et la méthode en callable
        $controller = [$controllerName, $method];

        $arguments = $match['params'];

        // Le container appelle maintenant le controller avec les arguments
        $response = $container->call($controller, $arguments);

        $response->send();
    } else {
        echo "404";
    }

