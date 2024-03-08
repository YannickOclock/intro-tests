<?php

    // Un exemple d'utilisation de la classe

    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Classes\Calculator;
    use Mvc\Controller\HomeController;

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
    $match = $altorouter->match();
    if ($match) {
        $controller = new $match['target']['controller']();
        $method = $match['target']['method'];
        $response = $controller->$method();
        $response->send();
    } else {
        echo "404";
    }

