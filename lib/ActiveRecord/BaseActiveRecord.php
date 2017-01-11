<?php

namespace Academy\ActiveRecord;

use Academy\App;
use Academy\Models\BaseModel;

/**
 * Class BaseActiveRecord is a base class for ActiveRecord instances,
 * that represents rows in database tables.
 *
 * @package Academy\ActiveRecord
 */
class BaseActiveRecord extends BaseModel
{
    /**
     * Finds record by primary key.
     *
     * @param mixed $pkValue Primary key value.
     *
     * @return mixed
     */
    public function findByPk($pkValue)
    {
        $pkValue = (array) $pkValue;
        $pk = (array) static::getPrimaryKey();
        $tableName = static::tableName();
        $query = "SELECT * FROM {$tableName} WHERE ";
        foreach ($pk as $key => $param) {
            $query .= "`{$param}` = :pk{$key} && ";
        }
        
        $query = rtrim($query, '& ');
        $statement = App::$i->db->prepare($query);
        foreach ($pkValue as $key => $value) {
            $statement->bindValue(":pk{$key}", $value);
        }
        
        $statement->execute();
        return $statement->rowCount()
            ? $statement->fetchObject(static::class)
            : null;
    }
}
