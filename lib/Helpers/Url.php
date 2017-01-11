<?php

namespace Academy\Helpers;

/**
 * Class Url is a helper, which is responsible for URL transformation.
 *
 * @package Academy\Helpers
 */
class Url
{
    
    /**
     * Converts internal application route into proper URL.
     *
     * @param string $route Route to get correct URL representation for.
     *
     * @return string
     */
    public static function to($route)
    {
        $route = trim($route, '/');
        $basePath = \Academy\App::$i->request->getBasePath();
        
        return "{$basePath}/{$route}";
    }
}