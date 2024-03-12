<?php

namespace Mvc\Controller;

use Mvc\Utils\HtmlResponse;

class AbstractViewController
{
    public function addFlashMessage(string $message): void
    {
        $_SESSION['flashMessage'] = $message;
    }
    public function show($viewName, $data = []): HtmlResponse
    {
        // On récupère les flash messages
        $flashMessages = [];
        if (isset($_SESSION['flashMessage'])) {
            $flashMessages[] = $_SESSION['flashMessage'];
            unset($_SESSION['flashMessage']);
        }

        $response = new HtmlResponse();
        $response->addHeader('Content-Type: text/html; charset=utf-8');
        $response->setStatusCode(200);
        $response->addData($data);
        $response->addView(__DIR__ . "/../Views/parts/header.tpl.php");
        $response->addView(__DIR__ . "/../Views/pages/$viewName.tpl.php");
        $response->addView(__DIR__ . "/../Views/parts/footer.tpl.php");
        return $response;
    }
}