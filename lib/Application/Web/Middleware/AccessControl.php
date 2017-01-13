<?php

namespace Academy\Application\Web\Middleware;

use Academy\App;
use Academy\Application\Web\Exceptions\HttpForbiddenException;

/**
 * Class AccessControl is a middleware component to apply
 * access control checks for assigned controllers and action.
 *
 * @package Academy\Application\Web\Middleware
 */
class AccessControl extends BaseMiddleware implements MiddlewareInterface
{
    
    /**
     * Current request is allowed to be processed.
     *
     * @var boolean
     */
    protected $requestAllowed = true;
    
    /**
     * {@inheritdoc}
     *
     * @return void
     *
     * @throws HttpForbiddenException In case if further request processing is forbidden.
     */
    public function apply()
    {
        $this->checkAllowRules();
        $this->checkDenyRules();
        
        if (!$this->requestAllowed) {
            throw new HttpForbiddenException();
        }
    }
    
    /**
     * Runs check for 'allow' set of rules.
     *
     * @return void
     */
    protected function checkAllowRules()
    {
        if (empty($this->rules['allow'])) {
            return;
        }
        
        foreach ($this->rules['allow'] as $rule) {
            list($actions, $roles, $users) = $this->getRuleConfig($rule);
            
            if (!in_array($this->controller->actionId, $actions)) {
                continue;
            }
            
            if (in_array('@', $roles)
                && App::$i->user->isGuest()
            ) {
                App::$i->response->redirect(
                    App::$i->config->get('loginUrl')
                );
            }
            
            if (!empty($users)
                && !in_array(App::$i->user->identity->login, $users)
            ) {
                $this->requestAllowed = false;
                break;
            }
        }
    }
    
    /**
     * Runs check for access denying rules.
     *
     * @return void
     */
    protected function checkDenyRules()
    {
        if (empty($this->rules['deny'])) {
            return;
        }
        
        // TODO: implement deny rules check
    }
    
    /**
     * Traverses rule's configuration array and returns collected
     * actions, user roles and users, if available.
     *
     * @param array $rule Rule configuration array.
     *
     * @return array
     */
    protected function getRuleConfig(array $rule)
    {
        $actions = !empty($rule['actions'])
            ? (array) $rule['actions']
            : [];
    
        $users = [];
        if (!empty($rule['users'])) {
            $roles = ['@'];
            $users = $rule['users'];
        } else {
            $roles = $rule['roles'];
        }
        
        return [$actions, $roles, $users];
    }
}
