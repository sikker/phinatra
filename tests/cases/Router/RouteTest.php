<?php

namespace Sikker\Phinatra\Router;

use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testRoute()
    {
        $mockCallback = function () {
            return 'hello, world!';
        };
        $route = new Route('/here/be/dragons', $mockCallback, 'GET');
        $this->assertEquals('/here/be/dragons', $route->getPath());
        $this->assertEquals($mockCallback, $route->getCallback());
        $this->assertEquals('GET', $route->getMethod());
    }
}
