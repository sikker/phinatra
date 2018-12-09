<?php

namespace Sikker\Phinatra\Router;

use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    private $storedServerVar;

    public function setUp()
    {
        $this->storedServerVar = $_SERVER;
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['SCRIPT_NAME'] = 'index.php';
        $_SERVER['REQUEST_URI'] = '';
        $_SERVER['HTTPS'] = 'on';
    }

    public function testValidatePath()
    {
        $_SERVER['REQUEST_URI'] = 'index.php/foo/bar/baz';
        $path = new Path();
        $this->assertFalse($path->validatePath('/spam/ham/eggs'));
        $this->assertTrue($path->validatePath('/foo/bar/baz'));

        $_SERVER['REQUEST_URI'] = '/charlemagne';
        $path = new Path();
        $this->assertFalse($path->validatePath('/foo/bar/baz'));
        $this->assertTrue($path->validatePath('/charlemagne'));
    }

    public function testValidateMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $path = new Path();
        $this->assertTrue($path->validateMethod('put'));
        $this->assertFalse($path->validateMethod('get'));
    }

    public function testBaseUrl()
    {
        $path = new Path();
        $this->assertNotEquals('http://example.org/', $path->getBaseUrl());
        $this->assertEquals('https://example.com/', $path->getBaseUrl());
    }

    public function testUrl()
    {
        $path = new Path();
        $baseUrl = 'https://example.com/';
        $uri = '/soup/bread';
        $this->assertEquals($baseUrl . $uri, $path->getUrl('/soup/bread'));
    }

    public function testUri()
    {
        $_SERVER['REQUEST_URI'] = 'ghengis/khan';
        $path = new Path();
        $this->assertEquals(['ghengis', 'khan'], $path->getUri());
    }

    public function testHttps()
    {
        $path = new Path();
        $this->assertTrue($path->isHttps());
        $_SERVER['HTTPS'] = 'off';
        $path = new Path();
        $this->assertFalse($path->isHttps());
    }

    public function tearDown()
    {
        $_SERVER = $this->storedServerVar;
    }
}
