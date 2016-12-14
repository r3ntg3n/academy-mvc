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
     * Resolved request route by parsing `route` GET query parameter.
     *
     * @return $this
     */
    public function resolve()
    {
        $defaults = [
            'controller' => App::$i->config->get('defaultController'),
            'action' => 'index'
        ];
    
        $resolvedPath = [];
        if ($route = App::$i->request->getParam('route')) {
            $parts = explode('/', $route);
            $resolvedPath = [
                'controller' => $parts[0],
                'action' => !empty($parts[1]) ? $parts[1] : null,
            ];
        }
        
        $this->route = $resolvedPath + $defaults;
        
        $controllerClass = ucfirst($this->route['controller']) . 'Controller';
        $controllerClass = "\\Academy\\Controllers\\{$controllerClass}";
        $controllerAction = 'action' . ucfirst($this->route['action']);
        
        $this->route = [
            'controller' => $controllerClass,
            'action' => $controllerAction,
        ];
        
        return $this;
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
     * @return string
     */
    public function getAction()
    {
        return $this->route['action'];
    }
}
