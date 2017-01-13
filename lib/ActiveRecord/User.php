<?php

namespace Academy\ActiveRecord;

/**
 * Class User is an active record class for `user` table.
 *
 * @package Academy\ActiveRecord
 */
class User extends BaseActiveRecord
{
    
    const STATUS_BANNED = 0;
    const STATUS_ACTIVE = 1;
    
    /**
     * Assigned table name.
     *
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }
}
