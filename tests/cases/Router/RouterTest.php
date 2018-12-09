<?php

namespace Sikker\Phinatra\Router;

use PHPUnit\Framework\TestCase;
use \Sikker\Phinatra\Request;
use \Sikker\Phinatra\Response;

class RouterTest extends TestCase
{
    private $mockPath;
    private $mockRoute;
    private $mockRequest;
    private $mockResponse;

    public function setUp()
    {
        $this->mockPath = $this->createMock(Path::class);
        $this->mockPath->method('validatePath')->willReturn(true);
        $this->mockPath->method('validateMethod')->willReturn(true);
        $this->mockRoute = $this->createMock(Route::class);
        $this->mockRoute->method('getCallback')->willReturn(function (Request $request, Response $response) {
            return $response;
        });
        $this->mockRequest = $this->createMock(Request::class);
        $this->mockResponse = $this->createMock(Response::class);
        $this->mockResponse->method('getOutput')->willReturn('hello, world!');
    }

    public function testValidRoute()
    {
        $router = new Router($this->mockPath);
        $router->attach($this->mockRoute);
        $result = $router->route($this->mockRequest, $this->mockResponse);
        $this->assertEquals($this->mockResponse, $result);
    }

    public function testInvalidRoute()
    {
        $this->mockPath = $this->createMock(Path::class);
        $this->mockPath->method('validatePath')->willReturn(false);
        $this->mockPath->method('validateMethod')->willReturn(true);
        $router = new Router($this->mockPath);
        $router->attach($this->mockRoute);
        $this->expectException(RouterException::class);
        $result = $router->route($this->mockRequest, $this->mockResponse);
    }
}
