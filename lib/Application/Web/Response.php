<?php

namespace Academy\Application\Web;

use Academy\Helpers\Url;

/**
 * Class Response
 *
 * @package Academy\Application\Web
 */
class Response
{
    const STATUS_OK = 200;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_SERVER_ERROR = 500;
    
    /**
     * HTTP response status map to response message.
     *
     * @var array
     */
    private $statusMessageMap = [
        self::STATUS_OK => 'OK',
        self::STATUS_UNAUTHORIZED => 'Authorization required',
        self::STATUS_FORBIDDEN => 'Forbidden',
        self::STATUS_NOT_FOUND => 'Not Found',
        self::STATUS_SERVER_ERROR => 'Internal Server Error',
    ];
    
    /**
     * Response HTTP status code.
     *
     * @var integer
     */
    private $status = 200;
    
    /**
     * Response body contents.
     *
     * @var mixed
     */
    private $body;
    
    /**
     * A list of headers to be send within response.
     *
     * @var array
     */
    private $headers = [];
    
    /**
     * Sets request response code status.
     *
     * @param integer $status HTTP response status code
     *
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = (int) $status;
    }
    
    /**
     * Sets response body content.
     *
     * @param mixed $body Response body.
     *
     * @return void
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
    
    /**
     * Adds header definition into response.
     *
     * @param string $header Header definition.
     *
     * @return void
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
    }
    
    /**
     * Sends response content to client.
     *
     * @return void
     */
    public function send()
    {
        $this->sendHeaders();
        echo $this->body;
        exit;
    }
    
    /**
     * Sends response headers to the browser.
     *
     * @return void
     */
    protected function sendHeaders()
    {
        $statusMessage = $this->statusMessageMap[$this->status];
        header("HTTP/1.1 {$this->status} {$statusMessage}");
        
        foreach ($this->headers as $header) {
            header($header, true);
        }
    }
    
    /**
     * Redirects user to the route.
     *
     * @param string $route Route to redirect user to.
     *
     * @return void
     */
    public function redirect($route)
    {
        $location = Url::to($route);
        $this->headers = ["Location: {$location}"];
        $this->send();
    }
}
