<?php

declare(strict_types = 1);

namespace pwf\components\datamapper\abstraction;

use pwf\components\datamapper\interfaces\Model as IModel;

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
     * @return IModel
     */
    public function setAttributes(array $attributes): IModel
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Set attribute
     *
     * @param string $name
     * @param mixed $value
     * @return IModel
     */
    public function setAttribute(string $name, $value): IModel
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
    public function getAttribute(string $name)
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
    public function attributeExists(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    /**
     * Overload
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
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
    public function __set(string $name, $value)
    {
        $this->setAttribute($name, $value);
    }

    /**
     * Overload
     *
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return $this->attributeExists($name);
    }

    /**
     * Unset attribute
     *
     * @param string $name
     */
    public function __unset(string $name)
    {
        $this->setAttribute($name, null);
    }
}