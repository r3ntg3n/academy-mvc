<?php

namespace Academy\Controllers;

use Academy\App;
use Academy\Application\Web\Exceptions\HttpForbiddenException;
use Academy\Models\SignupFormModel;
use Academy\Models\UserModel;

/**
 * Class UserController is a controller class for user related requests.
 *
 * @package Academy\Controllers
 */
class UserController extends BaseController
{
    
    public function middleware()
    {
        $guestAllowedActions = ['index', 'signup'];
        if (!in_array($this->actionId, $guestAllowedActions)
            && App::$i->user->isGuest()
        ) {
            throw new HttpForbiddenException();
        }
    }
    
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
     *
     * @throws HttpForbiddenException In case if current user is a guest user.
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
    
    public function actionEdit($id)
    {
        if (App::$i->user->isAdmin()) {
            App::$i->response->setStatus(403);
            App::$i->response->setBody('Not allowed!');
            App::$i->response->send();
        }
    }
    
    /**
     * Renders sign up form.
     *
     * @return void
     */
    public function actionSignup()
    {
        $model = new SignupFormModel();
        if ($model->load(App::$i->request->post())) {
            var_dump($model);
            exit;
        }
        
        $this->render('signup', ['model' => $model]);
    }
}
