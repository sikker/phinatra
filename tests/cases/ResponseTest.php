<?php

namespace Sikker\Phinatra;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    public function testStatusCode()
    {
        $response = new Response();
        $this->assertEquals(200, $response->getStatusCode());
        $response->setStatusCode(400);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testContentType()
    {
        $response = new Response();
        $this->assertEquals('text/html', $response->getContentType());
        $response->setContentType('application/json');
        $this->assertEquals('application/json', $response->getContentType());
    }

    public function testCharset()
    {
        $response = new Response();
        $this->assertEquals('UTF-8', $response->getCharset());
        $response->setCharset('ISO-8859-15');
        $this->assertEquals('ISO-8859-15', $response->getCharset());
    }

    public function testOutput()
    {
        $response = new Response();
        $this->assertEmpty($response->getOutput());
        $outputs = ['spam', 'ham', 'eggs'];
        $response->setOutput($outputs[0]);
        $this->assertEquals($outputs[0], $response->getOutput());
        $response->prependOutput($outputs[1]);
        $this->assertEquals($outputs[1] . $outputs[0], $response->getOutput());
        $response->appendOutput($outputs[2]);
        $this->assertEquals($outputs[1] . $outputs[0] . $outputs[2], $response->getOutput());
    }

    public function testRedirect()
    {
        $response = new Response();
        $this->assertEmpty($response->getRedirect());
        $response->setRedirect('https://www.google.com/');
        $this->assertEquals('https://www.google.com/', $response->getRedirect());
    }

    public function testHandleOutputResponse()
    {
        $response = new Response();
        $response->setOutput('hello, world');
        ob_start();
        $response->handle();
        $output = ob_get_clean();
        $this->assertEquals('hello, world', $output);
    }
}
