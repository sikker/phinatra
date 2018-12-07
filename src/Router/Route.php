<?php namespace Sikker\Phinatra\Router;

class Route {

	private $path;
	private $method;
	private $callback;

	public function __construct($path,\Closure $callback, $method = null) {
		$this->path = $path;
		$this->callback = $callback;
		$this->method = $method;
	}

	public function getPath() {
		return $this->path;
	}

	public function getMethod() {
		return $this->method;
	}

	public function getCallback() {
		return $this->callback;
	}

}
