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
     * Tells if current user is a guest user.
     *
     * @return boolean
     */
    public function isGuest()
    {
        return false;
    }
}
