<?php

    // Un exemple d'utilisation de la classe

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Classes\Calculator;
    use Mvc\Controller\HomeController;
    use Mvc\Models\PostModel;

    // Test de la classe Calculator (en direct)

    //$calculator = new Calculator();
    //$resultat = $calculator->add(2, 3);
    //echo "<h1>Un exemple d'utilisation de la classe</h1>";
    //echo "<p>2 + 3 = $resultat</p>";


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
    $match = $altorouter->match();
    if ($match) {
        $controllerName = $match['target']['controller'];
        $controller = new $controllerName();
        $method = $match['target']['method'];

        // PLUS TARD, CELA SERA GERE AUTOMATIQUEMENT PAR LE CONTENEUR DE DEPENDANCES
        $arguments = $match['params'];
        if($controllerName === HomeController::class && $method === 'showPosts') {
            $arguments[] = new PostModel();
        }

        $response = $controller->$method(...$arguments);
        $response->send();
    } else {
        echo "404";
    }

