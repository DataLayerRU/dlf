<?php

namespace pwf\components\datamapper\abstraction;

abstract class Model implements \pwf\components\datamapper\interfaces\Model
{
    /**
     * Model attributes
     *
     * @var array
     */
    private $attributes;

    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * Set attributes
     *
     * @param array $attributes
     * @return \pwf\components\datamapper\abstraction\Model
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set attribute
     *
     * @param string $name
     * @param mixed $value
     * @return \pwf\components\datamapper\abstraction\Model
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Get attribute by name
     *
     * @param string $name
     * @return mixed
     */
    public function getAttribute($name)
    {
        $result = null;

        if ($this->attributeExists($name)) {
            $result = $this->attributes[$name];
        }

        return $result;
    }

    /**
     * Is attribute exists
     *
     * @param string $name
     * @return bool
     */
    public function attributeExists($name)
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Overload
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->attributeExists($name)) {
            return $this->getAttribute($name);
        }
        return null;
    }

    /**
     * Overload
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    /**
     * Overload
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->attributeExists($name);
    }

    /**
     * Unset attribute
     *
     * @param string $name
     */
    public function __unset($name)
    {
        $this->setAttribute($name, null);
    }
}