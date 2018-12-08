<?php

namespace Sikker\Phinatra\Router;

/**
 * Route class
 *
 * @package Sikker\Phinatra\Router
 * @since 1.0.0
 * @author Per Sikker Hansen <persikkerhansen@gmail.com>
 * @license CC-BY-4.0
 */
class Route
{

    private $path;
    private $method;
    private $callback;

    /**
     * @param string the uri the route will be invoked on
     * @param \Closure the callback method that will be run if the route is invoked
     * @param string which HTTP method will be used for the request
     */
    public function __construct(string $path, \Closure $callback, string $method = null)
    {
        $this->path = $path;
        $this->callback = $callback;
        $this->method = $method;
    }

    /**
     * @return string the uri the route will be invoked on
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string which HTTP method will be used for the request
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return \Closure the callback method that will be run if the route is invoked
     */
    public function getCallback()
    {
        return $this->callback;
    }
}
