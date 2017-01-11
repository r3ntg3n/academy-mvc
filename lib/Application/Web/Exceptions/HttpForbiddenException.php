<?php

namespace Academy\Application\Web\Exceptions;

use Academy\Application\Web\Response;

/**
 * Class HttpForbiddenException is an exception class,
 * that represents HTTP 403 Forbidden response status.
 *
 * @package Academy\Application\Web\Exceptions
 */
class HttpForbiddenException extends BaseHttpException
{
    
    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $code = Response::STATUS_FORBIDDEN;
}
