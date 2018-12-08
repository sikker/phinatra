<?php

namespace Sikker\Phinatra;

/**
 * Request class
 *
 * @package Sikker\Phinatra
 * @since 1.0.0
 * @author Per Sikker Hansen <persikkerhansen@gmail.com>
 * @license CC-BY-4.0
 */
class Request
{

    private $path;
    private $method;
    private $isAjax;
    private $input;
    private $memory = array();

    /**
     * Constructor
     *
     * @param Router\Path contains methods for normalizing and validating incoming and outgoing URI paths
     */
    public function __construct(Router\Path $path)
    {
        $this->path = $path;
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->isAjax = (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
             ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        );
        $this->input = $_POST;
    }

    /**
     * Get the path object used
     *
     * @return Router\Path contains methods for normalizing and validating incoming and outgoing URI paths
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the method of the current request
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the inputted form data for the current request
     *
     * @return array
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Get what is currently stored in the request memory
     *
     * @return array
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Store a data array in the request memory
     *
     * @param array
     */
    public function setMemory(array $memory)
    {
        $this->memory = $memory;
    }

    /**
     * Check the request for input
     * 
     * Checks for specific input (by providing a key to check for) or whether there's any input in general.
     *
     * @param string OPTIONAL. If you want to check for a particular input value, provide the key here. 
     * @return bool
     */
    public function isInput(string $key = null)
    {
        if ($key !== null) {
            return (isset($this->input[$key]) && ! empty($this->input[$key]));
        }
        return (empty($this->input));
    }

    /**
     * Whether or not this request is an AJAX one
     *
     * @return bool
     */
    public function isAjax()
    {
        return $this->isAjax;
    }
}
