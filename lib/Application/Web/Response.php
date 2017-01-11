<?php

namespace Academy\Application\Web;

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
     * Sends response content to client.
     *
     * @return void
     */
    public function send()
    {
        $statusMessage = $this->statusMessageMap[$this->status];
        header("HTTP/1.1 {$this->status} {$statusMessage}");
        echo $this->body;
        exit;
    }
}
