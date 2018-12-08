<?php

namespace Sikker\Phinatra\Router;

/**
 * Router class
 *
 * Configure your router by attaching route objects to it, and then pass the request and an empty response object
 * to it when you are ready to route.
 *
 * @package Sikker\Phinatra\Router
 * @since 1.0.0
 * @author Per Sikker Hansen <persikkerhansen@gmail.com>
 * @license CC-BY-4.0
 */
class Router
{

    private $routes = array();
    private $path;

    /**
     * @param Path contains methods for normalizing and validating incoming and outgoing URI paths
     */
    public function __construct(Path $path)
    {
        $this->path = $path;
    }

    /**
     * @param Route an object with a path and a callback for that path to attach to the router
     * @return void
     */
    public function attach(Route $route)
    {
        if ($this->path->validatePath($route->getPath()) && $this->path->validateMethod($route->getMethod())) {
            $this->routes[] = $route;
        }
    }

    /**
     * @param \Sikker\Phinatra\Request contains data about the current request being made
     * @param \Sikker\Phinatra\Response empty object to inject the route output into
     * @return \Sikker\Phinatra\Response the resulting response
     */
    public function route(\Sikker\Phinatra\Request $request, \Sikker\Phinatra\Response $response)
    {
        if (empty($this->routes)) {
            throw new RouterException('Invalid route path');
        }
        foreach ($this->routes as $route) {
            $response = call_user_func($route->getCallback(), $request, $response);
        }
        return $response;
    }
}
