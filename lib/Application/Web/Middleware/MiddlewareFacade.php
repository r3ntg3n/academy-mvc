<?php

namespace Academy\Application\Web\Middleware;

use Academy\Controllers\BaseController;

/**
 * Class MiddlewareFacade
 *
 * @package Academy\Application\Web\Middleware
 */
class MiddlewareFacade
{
    
    /**
     * Current processed controller.
     *
     * @var BaseController
     */
    protected $controller;
    
    /**
     * Controller's assigned middlewares.
     *
     * @var array
     */
    protected $middleware = [];
    
    /**
     * MiddlewareFacade constructor.
     *
     * @param BaseController $controller Controller to apply middlewares for.
     */
    public function __construct(BaseController $controller)
    {
        $this->controller = $controller;
        $this->middleware = $this->controller->middleware();
    }
    
    /**
     * Applied assigned middlewares.
     *
     * @return void
     *
     * @throws \LogicException If middleware configuration array missing components class name.
     * @throws \BadMethodCallException If assigned middleware component does not implement `MiddlewareInterface`.
     */
    public function apply()
    {
        if (empty($this->middleware)) {
            return;
        }
           
        foreach ($this->middleware as $name => $config) {
            if (empty($config['class'])) {
                throw new \LogicException("Middleware config for '{$name}' must have assigned class");
            }
            
            $middlewareClass = $config['class'];
            $rules = !empty($config['rules']) ? $config['rules'] : [];
            
            /* @var $middleware BaseMiddleware */
            $middleware = new $middlewareClass();
            $middleware->setController($this->controller)->setRules($rules);
            
            if (!($middleware instanceof MiddlewareInterface)) {
                throw new \BadMethodCallException('Middleware component must implemented MiddlewareInterface');
            }
            
            $middleware->apply();
        }
    }
}
