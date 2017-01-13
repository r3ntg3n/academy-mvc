<?php

namespace Academy\Application\Web;

use Academy\App;

/**
 * Class Router is responsible for resolution of all incoming HTTP requests.
 *
 * It tries to parse `route` GET query parameter and define which controller
 * and which controller's method should be called.
 *
 * @package Academy\Application\Web
 */
class Router
{
    
    /**
     * Resolved request route.
     *
     * @var array
     */
    protected $route = [];
    
    /**
     * Route parameters.
     *
     * @var array
     */
    protected $routeParams = [];
    
    /**
     * Resolved request route by parsing `route` GET query parameter.
     *
     * @return $this
     */
    public function resolve()
    {
        $defaults = [
            'controller' => App::$i->config->get('defaultController'),
        ];
    
        $resolvedPath = [];
        if ($route = App::$i->request->getParam('route')) {
            $route = trim($route, '/');
            $parts = explode('/', $route);
            $resolvedPath = [
                'controller' => strtolower(array_shift($parts)),
                'action' => !empty($parts[0])
                    ? strtolower(array_shift($parts))
                    : null,
            ];
            
            $this->resolveParams($parts);
        }
        
        $this->route = $resolvedPath + $defaults;
        
        return $this;
    }
    
    /**
     * Resolves route parameters.
     *
     * @param array $params Parameters array
     *
     * @return void
     */
    public function resolveParams(array $params)
    {
        if (empty($params)) {
            return;
        }
        
        foreach ($params as $key => $value) {
            if (!($key % 2)) {
                $this->routeParams[$value] = $params[$key + 1];
            }
        }
    }
    
    /**
     * Returns resolved controller class name.
     *
     * @return string
     */
    public function getController()
    {
        return $this->route['controller'];
    }
    
    /**
     * Returns resolved controller's action method.
     *
     * @return mixed
     */
    public function getAction()
    {
        return !empty($this->route['action'])
            ? $this->route['action']
            : null;
    }
    
    /**
     * Returns resolved route parameters if any found.
     *
     * @return array
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }
}
