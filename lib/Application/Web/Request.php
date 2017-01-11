<?php

namespace Academy\Application\Web;

use Academy\App;
use Academy\Application\Web\Exceptions\BaseHttpException;
use Academy\Controllers\BaseController;

/**
 * Class Request is responsible for HTTP request handling.
 *
 * @version 0.1.alpha
 */
class Request
{
    
    /**
     * Contains GET request query params.
     *
     * @var array
     */
    protected $queryParams = [];
    
    /**
     * Contains data retrieved via POST request.
     *
     * @var array
     */
    protected $postData = [];
    
    /**
     * Base path to the application.
     *
     * @var string
     */
    protected $basePath;
    
    /**
     * Current request method.
     *
     * @var string
     */
    protected $method;
    
    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->queryParams = $_GET;
        $this->postData = $_POST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->resolveBasePath();
    }
    
    /**
     * Resolves actual base path of the application.
     *
     * @return void
     */
    protected function resolveBasePath()
    {
        $basePath = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);
        $this->basePath = rtrim($basePath, '/');
    }
    
    /**
     * Resolved incoming HTTP request.
     *
     * @return void
     */
    public function handleRequest()
    {
        $router = new Router();
        $controllerClass = $router->resolve()->getController();
        $controllerAction = $router->getAction();
        $this->queryParams += $router->getRouteParams();
        
        try {
            $reflectionMethod = new \ReflectionMethod($controllerClass, $controllerAction);
        } catch (\Exception $e) {
            App::$i->response->setStatus(404);
            App::$i->response->send();
        }
        
        ///////
        
        $actionParams = [];
        foreach ($reflectionMethod->getParameters() as $param) {
            $actionParams[$param->name] = $this->getParam($param->name);
        }
        
        /* @var $controllerInstance BaseController */
        $controllerInstance = new $controllerClass();
        $controllerAction = str_replace('action', '', $controllerAction);
        $controllerInstance->actionId = strtolower($controllerAction);
        
        try {
            $controllerInstance->middleware();
            $reflectionMethod->invokeArgs($controllerInstance, $actionParams);
        } catch (\Exception $e) {
            $status = ($e instanceof BaseHttpException) ? $e->getCode() : 500;
            App::$i->response->setStatus($status);
        }
        
        App::$i->response->send();
    }
    
    protected function runMiddleware(array $middleware)
    {
        if (empty($middleware)) {
            return;
        }
        $user = App::$i->user;
        
    }
    
    /**
     * Tries to find GET query parameter by it's name and return it's value if found.
     * If no such parameter was found, `$default` value will be returned.
     *
     * @param string     $name    GET parameter name.
     * @param mixed|null $default Default value, if parameter was not found.
     *
     * @return mixed|null
     */
    public function getParam($name, $default = null)
    {
        return isset($this->queryParams[$name])
            ? $this->queryParams[$name]
            : $default;
    }
    
    /**
     * Returns query params set.
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }
    
    /**
     * Returns request's base path.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }
    
    /**
     * Returns, whether current request is made via POST.
     *
     * @return boolean
     */
    public function isPost()
    {
        return $this->method == 'POST';
    }
    
    /**
     * Returns collected POST data.
     *
     * @return array
     */
    public function post()
    {
        return $this->postData;
    }
}
