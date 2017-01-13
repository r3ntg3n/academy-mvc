<?php

namespace Academy\Application\Web\Middleware;

/**
 * Interface MiddlewareInterface is an interface, which must be implemented
 * by any middleware layer in the system.
 *
 * @package Academy\Application\Web\Middleware
 */
interface MiddlewareInterface
{
    
    /**
     * Applies middleware logic to controller.
     *
     * @return mixed
     */
    public function apply();
}
