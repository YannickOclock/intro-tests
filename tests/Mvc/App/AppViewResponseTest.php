<?php

namespace Tests\Mvc\App;

use Mvc\Utils\HtmlResponse;
use PHPUnit\Framework\TestCase;

class AppViewResponseTest extends TestCase
{
    public function testViewResponse()
    {
        $response = new HtmlResponse();
        $response->addHtmlContent('Hello World');
        ob_start();
        $response->send();
        $content = ob_get_clean();
        $this->assertEquals('Hello World', $content);
    }

    public function testAddHeader()
    {
        $response = new HtmlResponse();
        $response->addHeader('X-My-Header: my-value');
        ob_start();
        $response->send();
        $content = ob_get_clean();
        $this->assertContains('X-My-Header: my-value', $response->getHeaders());
    }

    public function testStatusCodeNotDefined()
    {
        $response = new HtmlResponse();
        $this->assertEquals(null, $response->getStatusCode());
    }
}