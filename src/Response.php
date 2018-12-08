<?php

namespace Sikker\Phinatra;

/**
 * Response class
 *
 * @package Sikker\Phinatra
 * @since 1.0.0
 * @author Per Sikker Hansen <persikkerhansen@gmail.com>
 * @license CC-BY-4.0
 */
class Response
{

    private $statusCode = 200;
    private $contentType = 'text/html';
    private $charset = 'UTF-8';
    private $output;
    private $redirect;

    /**
     * Handles the response
     *
     * Performs output and redirect operations as required by the registered response.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->redirect !== null) {
            header('Location: ' . $this->redirect);
            die();
        }
        http_response_code($this->statusCode);
        header('Content-Type: ' . $this->contentType . '; charset=' . $this->charset);
        echo $this->output;
    }

    /**
     * Returns the status code of the response
     *
     * @return int the HTTP response status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Returns the content type of the response
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Returns the charset of the response
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Returns the output, if any, of the response
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Returns the redirect url, if any, of the response
     *
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }
    
    /**
     * Set the status code of the response
     *
     * Supports method chaining.
     *
     * @param int the status code
     * @return Response
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Sets the content type of the response
     *
     * Supports method chaining.
     *
     * @param int the content type
     * @return Response
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * Sets the charset of the response
     *
     * Supports method chaining.
     *
     * @param string the charset
     * @return Response
     */
    public function setCharset(string $charset)
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * Sets the output of the response
     *
     * Supports method chaining.
     *
     * @param string
     * @return Response
     */
    public function setOutput(string $output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * Append content to the output of the response
     *
     * Supports method chaining.
     *
     * @param string
     * @return Response
     */
    public function appendOutput(string $output)
    {
        $this->output = $this->output . $output;
        return $this;
    }

    /**
     * Prepend content to the output of the response
     *
     * Supports method chaining.
     *
     * @param string
     * @return Response
     */
    public function prependOutput(string $output)
    {
        $this->output = $output . $this->output;
        return $this;
    }

    /**
     * Set the redirect url of the response
     *
     * Supports method chaining.
     *
     * @param string
     * @return Response
     */
    public function setRedirect(string $redirect)
    {
        $this->redirect = $redirect;
        return $this;
    }
}
