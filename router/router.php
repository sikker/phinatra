<?php namespace Phinatra\Router;

class Router {

	private $routes = array();
	private $path;

	public function __construct(Path $path) {
		$this->path = $path;
	}

	public function attach(Route $route) {
		if ($this->path->validatePath($route->getPath()) && $this->path->validateMethod($route->getMethod())) {
			$this->routes[] = $route;
		}
	}

	public function route(\Phinatra\Request $request, \Phinatra\Response $response) {
		if (empty($this->routes)) {
			throw new RouterException('Invalid route path');
		}
		foreach ($this->routes as $route) {
			$response = call_user_func($route->getCallback(), $request, $response);
		}
		return $response;
	}

}
