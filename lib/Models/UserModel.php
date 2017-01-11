<?php

namespace Academy\Models;

use Academy\ActiveRecord\BaseActiveRecord;

/**
 * Class UserModel is a model class for `user` table.
 *
 * @package Academy\Models
 */
class UserModel extends BaseActiveRecord
{
    
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }
    
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public static function getPrimaryKey()
    {
        return 'id';
    }
}
