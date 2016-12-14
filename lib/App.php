<?php

namespace Academy;

/**
 * Base application class.
 *
 * @version 0.1.alpha
 */
class App
{

    /**
     * Contains current application instance.
     *
     * @var App
     */
    public static $i;

    /**
     * Database connection.
     *
     * @var \PDO
     */
    public $db;

    /**
     * App configuration.
     *
     * @var Application\Config
     */
    public $config;
    
    /**
     * Request handling component.
     *
     * @var Application\Web\Request
     */
    public $request;

    /**
     * Instantiated application.
     */
    public function __construct()
    {
        $this->init();
        self::$i = $this;
    }

    /**
     * Inits generic components.
     *
     * @return void
     */
    protected function init()
    {
        foreach (static::coreComponents() as $prop => $component) {
            $this->{$prop} = $component;
        }
    }
    
    /**
     * Bootstraps a set of core components, required by application to operate normally.
     *
     * @return array
     */
    protected function coreComponents()
    {
        $configFile = ROOT_PATH . '/config/config.php';
        $config = new Application\Config($configFile);

        extract($config->get('database'));
        $dsn = "mysql:host={$host};dbname={$dbname}";
        $db = new \PDO($dsn, $user, $password);

        return [
            'config' => $config,
            'db' => $db,
            'request' => new Application\Web\Request(),
        ];
    }
    
    /**
     * Actually, runs an application.
     *
     * @return void
     */
    public function run()
    {
        $this->request->handleRequest();
    }
}
