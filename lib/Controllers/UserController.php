<?php

namespace Academy\Controllers;

use Academy\Models\UserModel;

/**
 * Class UserController is a controller class for user related requests.
 *
 * @package Academy\Controllers
 */
class UserController extends BaseController
{
    
    /**
     * Renders a list of user on the page.
     *
     * @return void
     */
    public function actionIndex()
    {
        echo 'Hello, users!';
    }
    
    /**
     * Displays user details.
     *
     * @param integer $id User record ID.
     *
     * @return void
     */
    public function actionView($id)
    {
        $model = (new UserModel())->findByPk($id);
        if (is_null($model)) {
            header('Not Found', true, 404);
            exit;
        }
        
        $this->render('view', ['model' => $model]);
    }
}
