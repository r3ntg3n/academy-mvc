<?php

namespace Academy\Models;

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
    
    /**
     * Tries to collect model's attributes' values from request data array.
     *
     * @param array $requestData Request data array.
     *
     * @return boolean
     */
    public function load(array $requestData)
    {
        $nsPos = strrpos(static::class, '\\') + 1;
        $modelName = substr(static::class, $nsPos);
        $modelName = strstr($modelName, 'Model', true);
        
        if (empty($requestData[$modelName])) {
            return false;
        }
        
        $this->setAttributes($requestData[$modelName]);
        return true;
    }
    
    /**
     * Massive assignment of model's attributes' values.
     *
     * @param array $attributes Array of attributes to set.
     *
     * @return void
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }
}
