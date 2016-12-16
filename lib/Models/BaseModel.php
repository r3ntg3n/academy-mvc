<?php

namespace Academy\Models;

use Academy\App;

/**
 * Class BaseModel is a basic class for any model in application.
 *
 * @package Academy\Models
 */
class BaseModel
{
    
    /**
     * Model attribute values.
     *
     * @var array
     */
    protected $attributes = [];
    
    /**
     * Returns table name to work with.
     *
     * @return mixed
     */
    public static function tableName()
    {
    }
    
    /**
     * Returns table's primary key column(s).
     *
     * @return mixed
     */
    public static function getPrimaryKey()
    {
    }
    
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
    
    /**
     * Magic getter for model's attributes.
     *
     * @param string $name Attribute name.
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->attributes[$name])
            ? $this->attributes[$name]
            : null;
    }
    
    /**
     * Magic setter for model's attributes.
     *
     * @param string $name  Attribute name.
     * @param mixed  $value Attribute value.
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
