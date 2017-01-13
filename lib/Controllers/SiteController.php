<?php

namespace Academy\Controllers;

use Academy\App;

/**
 * Class SiteController is a default controller for application.
 *
 * @package Academy\Controllers
 */
class SiteController extends BaseController
{
    
    /**
     * Index action.
     *
     * @return void
     */
    public function actionIndex()
    {
        App::$i->response->setBody('index');
    }
}
