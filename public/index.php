<?php

    // Un exemple d'utilisation de la classe

    require_once __DIR__ . '/../vendor/autoload.php';

    use DI\ContainerBuilder;
    use Mvc\Controller\HomeController;
    use Symfony\Component\Dotenv\Dotenv;

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
        'controller' => HomeController::class
    ]);
    // show posts with async await fetch
    $altorouter->map('GET', '/posts-async', [
        'method' => 'showPostsAsync',
        'controller' => HomeController::class
    ]);
    $altorouter->map('GET', '/api/posts', [
        'method' => 'showApiPosts',
        'controller' => HomeController::class
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

