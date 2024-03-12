<?php

namespace Mvc\Controller;

use Mvc\Utils\HtmlResponse;

class AbstractViewController
{
    public function show($viewName, $data = []): HtmlResponse
    {
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