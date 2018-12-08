<?php

namespace Sikker\Phinatra\Router;

use \Sikker\Phinatra\Router\PathException;

/**
 * Path class
 *
 * @package Sikker\Phinatra\Router
 * @since 1.0.0
 * @author Per Sikker Hansen <persikkerhansen@gmail.com>
 * @license CC-BY-4.0
 */
class Path
{

    private $baseUrl;
    private $uri;
    private $isHttps;
    
    /**
     * Constructor
     */
    private function __construct()
    {
        $this->uri = $this->normalizePath($_SERVER['REQUEST_URI']);

        $this->isHttps = (
            isset($_SERVER['HTTPS'])
            && ! empty($_SERVER['HTTPS'])
            && strtolower($_SERVER['HTTPS']) !== 'off'
        );

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
        $this->baseUrl = (
            $this->isHttps ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . implode('/', $urlSegments);
    }

    /**
     * Singleton instance method
     *
     * @return Path
     */
    public static function &instance()
    {
        static $instance;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Validates a URI path
     *
     * @param string the path to validate
     * @return bool whether or not the path is valid
     */
    public function validatePath(string $path)
    {
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

    /**
     * Validates a HTTP method
     *
     * Check whether a given HTTP method is being invoked for the current request.
     *
     * @param string the method to check (GET, PUT etc.)
     * @return bool whether or not the method is valid for this request
     */
    public function validateMethod(string $method)
    {
        return ($method === null || strtolower($method) === strtolower($_SERVER['REQUEST_METHOD']));
    }

    /**
     * Get the base url for the site
     *
     * @return string the base url
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Turn a URI into a full URL
     *
     * Reformats a given URI to a processed URL including the base url, normalized URI and any query strings necessary
     *
     * @param string the URI to process
     * @return string the full URL
     */
    public function getUrl(string $uri)
    {
        $uri = $this->normalizePath($uri);
        $queryString = array();
        foreach ($uri as $key => $val) {
            if (is_string($key)) {
                $queryString[] = $key . '=' . $val;
            }
        }
        if (! empty($queryString)) {
            return $this->baseUrl . '/?' . implode('&', $queryString);
        }
        return $this->baseUrl . '/' . implode('/', $uri);
    }

    /**
     * Get the current URI
     *
     * @return string the current URI
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Whether or not the current request is HTTPS
     *
     * It really should be, by now.
     *
     * @return bool check whether the current request is HTTPS
     */
    public function isHttps()
    {
        return $this->isHttps;
    }

    /**
     * Normalize a URI/array of URI segments
     *
     * @param mixed a string (URI) or an array of URI segments
     * @return string returns the normalized URI
     * @throws PathException
     */
    private function normalizePath($path)
    {
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
                if (! is_string($value)) {
                    throw new PathException('Illegal path value type, must be string', $value);
                }
            }
            return $path;
        } elseif ($path === null) {
            return null;
        } else {
            throw new PathException('Illegal path type, must be valid null, _GET string, /-delimitered string or single-level array', $path);
        }
    }
}
