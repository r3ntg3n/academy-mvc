<?php

namespace Academy\Application\Web;

/**
 * Class User
 *
 * @package Academy\Application\Web
 */
class User
{
    
    /**
     * Contains user's identity data.
     *
     * @var object
     */
    public $identity;
    
    /**
     * Tells if current user is a guest user.
     *
     * @return boolean
     */
    public function isGuest()
    {
        return empty($_SESSION['authorized']);
    }
}
