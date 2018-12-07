<?php namespace Sikker\Phinatra\Router;

class Path {

	private $baseUrl;
	private $uri;
	private $isHttps;
	
	private function __construct() {
		$this->uri = $this->normalizePath($_SERVER['REQUEST_URI']);

		$this->isHttps = ( isset($_SERVER['HTTPS']) && ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off');

		$requestUri = explode('?', $_SERVER['REQUEST_URI']);
		$requestUri = $requestUri[0];
		$baseUrl = explode('/', str_replace('\\', '/', $requestUri));
		array_shift($baseUrl);
		$last = array_pop($baseUrl);
		if ($last !== '') {
			$baseUrl[] = $last;
		}
		$urlSegments = array();
		foreach ($baseUrl as $segment) {
			$urlSegments[] = $segment;
			if ($segment === basename($_SERVER['SCRIPT_NAME'])) {
				break;
			}
		}
		$this->baseUrl = ($this->isHttps ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . implode('/', $urlSegments);
	}

	public static function &instance() {
		static $instance;
		if ($instance === null) {
			$instance = new self();
		}
		return $instance;
	}

	public function validatePath($path) {
		if ($path === null) {
			return true;
		}
		$path = $this->normalizePath($path);
		$match = false;
		foreach ($path as $key => $val) {
			if (isset($this->uri[$key]) && $this->uri[$key] === $val) {
				$match = true;
			} else {
				$match = false;
			}
		}
		return $match;
	}

	public function validateMethod($method) {
		return ($method === null || strtolower($method) === strtolower($_SERVER['REQUEST_METHOD']));
	}

	public function getBaseUrl() {
		return $this->baseUrl;
	}

	public function getUrl($uri) {
		$uri = $this->normalizePath($uri);
		$queryString = array();
		foreach ($uri as $key => $val) {
			if (is_string($key)) {
				$queryString[] = $key . '=' . $val;
			}
		}
		if ( ! empty($queryString)) {
			return $this->baseUrl . '/?' . implode('&', $queryString);
		} 
		return $this->baseUrl . '/' . implode('/', $uri);
	}

	public function getUri() {
		return $this->uri;
	}

	public function isHttps() {
		return $this->isHttps;
	}

	private function normalizePath($path) {
		if (is_string($path)) {
			$path = preg_replace('/^(.*)\.php(.*)/', "$2", $path);
			$path = preg_replace('/^\//', '', $path);
			$path = preg_replace('/^\?/', '', $path);
			$path = preg_replace('/\/$/', '', $path);
			if (strpos($path, '=')) {
				$path = explode('&', $path);
				$finalPath = array();
				foreach ($path as $item) {
					$item = explode('=', $item);
					$finalPath[$item[0]] = $item[1];
				}
				return $finalPath;
			} elseif (strpos($path, '/')) {
				return explode('/', $path);
			} else {
				return array($path);
			}
		} elseif (is_array($path)) {
			foreach ($path as $key => $value) {
				if ( ! is_string($value)) {
					throw new \Sikker\Phinatra\Router\PathException('Illegal path value type, must be string', $value);
				}
			}
			return $path;
		} elseif ($path === null ){
			return null;
		} else {
			throw new \Sikker\Phinatra\Router\PathException('Illegal path type, must be valid null, _GET string, /-delimitered string or single-level array', $path);
		}
	}

}
