<?php

namespace Academy\Models;

use Academy\ActiveRecord\User;

/**
 * Class SigninFormModel is a model class for sign in form.
 * It checks user's login and validates password.
 *
 * @package Academy\Models
 */
class SigninFormModel extends BaseModel
{
    
    /**
     * Runs user's authentication.
     *
     * @return boolean
     */
    public function authenticate()
    {
        $user = (new User)->findByAttributes([
            'login' => $this->login
        ]);
        
        if ($user == null) {
            $error = "User <b>{$this->login}</b> not found.";
        }
        
        if ($user->status == User::STATUS_BANNED) {
            $error = "User <b>{$this->login}</b> is banned.";
        }
        
        if (!password_verify($this->password, $user->password_hash)) {
            $error = 'Incorrect password. Please, try again.';
        }
    
        if (!empty($error)) {
            $_SESSION['loginError'] = $error;
            return false;
        }
        
        $_SESSION['authorized'] = true;
        return true;
    }
}
