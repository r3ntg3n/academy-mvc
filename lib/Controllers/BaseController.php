<?php

namespace Academy\Controllers;

use Academy\App;

/**
 * Class BaseController is a basic controller class of application/
 *
 * @package Academy\Controllers
 */
class BaseController
{
    
    /**
     * Rendering layout.
     *
     * @var string
     */
    protected $layout = 'default/main';
    
    /**
     * Rendered page title.
     *
     * @var string
     */
    public $pageTitle;
    
    /**
     * Controller's ID resolved from route.
     *
     * @var string
     */
    public $id;
    
    /**
     * Current invoked controller's actions name.
     *
     * @var string
     */
    public $actionId;
    
    /**
     * Default controller's action.
     *
     * @var string
     */
    public $defaultAction = 'index';
    
    /**
     * Returns assigned middleware for controller.
     *
     * @return array
     */
    public function middleware()
    {
        return [];
    }
    
    /**
     * Render view file, surrounding it with layout.
     *
     * @param string $viewFile View file name to render.
     * @param array  $params   Render parameters.
     *
     * @return void
     */
    public function render($viewFile, array $params = [])
    {
        ob_start();
        $this->renderPartial($viewFile, $params);
        $content = ob_get_contents();
        ob_clean();
        
        ob_start();
        require ROOT_PATH . "/layouts/{$this->layout}.php";
        $result = ob_get_contents();
        ob_clean();
        
        App::$i->response->setBody($result);
    }
    
    /**
     * Renders view file without wrapping it with layout.
     *
     * @param string $view   View file name to render.
     * @param array  $params View rendering parameters.
     *
     * @return void
     */
    public function renderPartial($view, array $params = [])
    {
        $filename = $this->resolveViewFilename($view);
        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $filename;
        $contents = ob_get_contents();
        ob_clean();
        
        echo $contents;
    }
    
    /**
     * Returns view filename by it's symbolic name.
     *
     * @param string $view View name.
     *
     * @return string
     */
    protected function resolveViewFilename($view)
    {
        $nsPosition = strrpos(static::class, '\\');
        $controller = trim(substr(static::class, $nsPosition), '\\');
        $viewPath = strtolower(strstr($controller, 'Controller', true));
        $viewFilepath = implode(DIRECTORY_SEPARATOR, [
            ROOT_PATH,
            'views',
            $viewPath,
            "{$view}.php"
        ]);
        
        return $viewFilepath;
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
        $route = trim($route, '/');
        if (strpos($route, '/') === false) {
            $route = "{$this->id}/{$route}";
        }
        
        App::$i->response->redirect($route);
    }
}
