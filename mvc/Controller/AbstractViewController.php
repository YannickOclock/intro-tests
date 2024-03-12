<?php

namespace Mvc\Controller;

use JetBrains\PhpStorm\NoReturn;
use Mvc\Utils\HtmlResponse;

class AbstractViewController
{
    public function addFlashMessage(string $message): void
    {
        $_SESSION['flashMessages'][] = $message;
    }

    #[NoReturn] public function redirect(string $route): void
    {
        header("Location: /$route");
        exit;
    }

    public function show($viewName, $data = [], $statusCode = 200): HtmlResponse
    {
        // On récupère les flash messages
        $flashMessages = [];
        if (isset($_SESSION['flashMessages'])) {
            $flashMessages = $_SESSION['flashMessages'];
            unset($_SESSION['flashMessages']);
        }

        $response = new HtmlResponse();
        $response->addHeader('Content-Type: text/html; charset=utf-8');
        $response->setStatusCode($statusCode);
        $response->addData($data);
        $response->addData(['flashMessages' => $flashMessages]);
        $response->addView(__DIR__ . "/../Views/parts/header.tpl.php");
        $response->addView(__DIR__ . "/../Views/pages/$viewName.tpl.php");
        $response->addView(__DIR__ . "/../Views/parts/footer.tpl.php");
        return $response;
    }
}