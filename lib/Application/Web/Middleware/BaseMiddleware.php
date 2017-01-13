<?php

namespace Academy\Application\Web\Middleware;

use Academy\Controllers\BaseController;

/**
 * Class BaseMiddleware is a basic class for middleware layers,
 * which process incomming request before running resolved controller's action.
 *
 * @package Academy\Application\Web\Middleware
 */
class BaseMiddleware
{
    
    /**
     * Controller instance to apply middleware for.
     *
     * @var BaseController
     */
    protected $controller;
    
    /**
     * Middleware configuration and runtime rules.
     *
     * @var array
     */
    protected $rules = [];
    
    /**
     * Sets applied controller.
     *
     * @param BaseController $controller Controller instance.
     *
     * @return $this
     */
    public function setController(BaseController $controller)
    {
        $this->controller = $controller;
        return $this;
    }
    
    /**
     * Sets internal middleware rules.
     *
     * @param array $rules Middleware rules.
     *
     * @return mixed
     */
    public function setRules(array $rules)
    {
        $this->rules = $this->prepareRules($rules);
    }
    
    /**
     * Prepares array rules according to middleware requirements.
     *
     * @param array $sourceRules Initial array of rules.
     *
     * @return array
     */
    protected function prepareRules(array $sourceRules)
    {
        return $sourceRules;
    }
}
