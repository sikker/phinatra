<?php namespace Sikker\Phinatra;

class Response {

	private $statusCode = 200;
	private $contentType = 'text/html';
	private $charset = 'UTF-8';
	private $output;
	private $redirect;

	public function handle() {
		if ($this->redirect !== null) {
			header('Location: ' . $this->redirect);
			die();
		}
		http_response_code($this->statusCode);
		header('Content-Type: ' . $this->contentType . '; charset=' . $this->charset);
		echo $this->output;
	}

	public function getStatusCode() {
		return $this->statusCode;
	}

	public function getContentType() {
		return $this->contentType;
	}

	public function getCharset() {
		return $this->charset;
	}

	public function getOutput() {
		return $this->output;
	}

	public function getRedirect() {
		return $this->redirect;
	}
	
	public function setStatusCode($statusCode) {
		$this->statusCode = (int) $statusCode;
		return $this;
	}

	public function setContentType($contentType) {
		$this->contentType = $contentType;
		return $this;
	}

	public function setCharset($charset) {
		$this->charset = $charset;
		return $this;
	}

	public function setOutput($output) {
		$this->output = $output;
		return $this;
	}

	public function appendOutput($output) {
		$this->output = $this->output . $output;
		return $this;
	}

	public function prependOutput($output) {
		$this->output = $output . $this->output;
		return $this;
	}

	public function setRedirect($redirect) {
		$this->redirect = $redirect;
		return $this;
	}

}
