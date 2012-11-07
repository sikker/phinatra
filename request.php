<?php namespace Phinatra;

class Request {

	private $path;
	private $method;
	private $isAjax;
	private $isMobile;
	private $input;

	public function __construct(Router\Path &$path) {
		$this->path = $path;
		$this->method = strtolower($_SERVER['REQUEST_METHOD']);
		$this->isAjax = ( 
			isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			 ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
		);
		$this->input = $_POST;	
	}

	public function &getPath() {
		return $this->path;
	}

	public function getMethod() {
		return $this->method;
	}

	public function getInput() {
		return $this->input;
	}

	public function isInput($key = null) {
		if ($key !== null) {
			return (isset($this->input[$key]) && ! empty($this->input[$key]));
		}
		return (empty($this->input));
	}

	public function isAjax() {
		return $this->isAjax;
	}

	public function isMobile() {
		return $this->isMobile();
	}


}
