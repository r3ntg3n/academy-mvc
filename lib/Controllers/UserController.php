<?php

namespace Academy\Controllers;

use Academy\App;
use Academy\Application\Web\Exceptions\HttpForbiddenException;
use Academy\Application\Web\Middleware\AccessControl;
use Academy\Models\SigninFormModel;
use Academy\Models\SignupFormModel;
use Academy\Models\UserModel;

/**
 * Class UserController is a controller class for user related requests.
 *
 * @package Academy\Controllers
 */
class UserController extends BaseController
{
    
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function middleware()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    'allow' => [
                        [
                            'actions' => ['index', 'view'],
                            'roles' => ['@']
                        ],
                        [
                            'actions' => ['edit'],
                            'users' => ['admin'],
                        ],
                        [
                            'actions' => ['signup'],
                            'roles' => ['*'],
                        ]
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Renders a list of user on the page.
     *
     * @return void
     */
    public function actionIndex()
    {
        $this->render('index');
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
    
    /**
     * User edit page.
     *
     * @param integer $id User id.
     *
     * @return void
     */
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
    
    /**
     * Renders sign in form.
     *
     * @return void
     */
    public function actionSignin()
    {
        $model = new SigninFormModel();
        if ($model->load(App::$i->request->post())
            && $model->authenticate()
        ) {
            $this->redirect('index');
        }
    
        $this->render('signin', ['model' => $model]);
    }
}
