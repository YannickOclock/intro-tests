<?php

namespace Tests\Mvc\App;

use Mvc\Utils\JsonResponse;
use PHPUnit\Framework\TestCase;

class AppJsonResponseTest extends TestCase
{
    public function testJsonResponse()
    {
        $response = new JsonResponse(['name' => 'John']);

        ob_start();
        $response->send();
        $content = ob_get_clean();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"name":"John"}', $content);
    }

    public function testAddContent()
    {
        $response = new JsonResponse(['name' => 'John']);
        $response->addContent(['age' => 30]);

        ob_start();
        $response->send();
        $content = ob_get_clean();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"name":"John","age":30}', $content);
    }

    public function testAddError()
    {
        $response = new JsonResponse(['name' => 'John']);
        $response->addError('Quelque chose se passe mal');

        ob_start();
        $response->send();
        $content = ob_get_clean();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('{"error":"Quelque chose se passe mal"}', $content);
    }

    public function testAddSuccess()
    {
        $response = new JsonResponse(['name' => 'John']);
        $response->addSuccess('Bravo');

        ob_start();
        $response->send();
        $content = ob_get_clean();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"name":"John","success":"Bravo"}', $content);
    }

    public function testConstructWithAdditionalHeaders() {
        $response = new JsonResponse(['name' => 'John'], 200, ['X-My-Header: my-value']);
        ob_start();
        $response->send();
        $content = ob_get_clean();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"name":"John"}', $content);
        $this->assertContains('X-My-Header: my-value', $response->getHeaders());
    }
}