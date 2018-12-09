<?php

namespace Sikker\Phinatra;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    private $mockPath;
    private $storedServerVar;
    private $storedPostVar;

    public function setUp()
    {
        $this->mockPath = $this->createMock(Router\Path::class);
        $this->storedServerVar = $_SERVER;
        $this->storedPostVar = $_POST;
    }

    public function testBasicRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $request = new Request($this->mockPath);
        $this->assertFalse($request->isAjax());
        $this->assertFalse($request->isInput());
        $this->assertEquals('get', $request->getMethod());
    }

    public function testAjaxrequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $request = new Request($this->mockPath);
        $this->assertTrue($request->isAjax());
    }

    public function testInputRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['one' => 'foo', 'two' => 'bar', 'three' => 'baz'];
        $request = new Request($this->mockPath);
        $this->assertTrue($request->isInput());
        $this->assertTrue($request->isInput('one'));
        $this->assertTrue($request->isInput('two'));
        $this->assertTrue($request->isInput('three'));
        $this->assertFalse($request->isInput('four'));
        $this->assertEquals($_POST, $request->getInput());
    }

    public function testRequestMemory()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $request = new Request($this->mockPath);
        $this->assertEmpty($request->getMemory());
        $memory = ['one' => 'foo', 'two' => 'bar'];
        $request->setMemory($memory);
        $this->assertEquals($memory, $request->getMemory());
    }

    public function tearDown()
    {
        $_SERVER = $this->storedServerVar;
        $_POST = $this->storedPostVar;
    }
}
