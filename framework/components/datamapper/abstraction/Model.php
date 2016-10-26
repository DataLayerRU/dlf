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

    /**
     * All other attributes
     *
     * @var array
     */
    private $dirtyAttributes;

    /**
     * Available properties
     *
     * @var array
     */
    private $properties = [];

    public function __construct(array $attributes = [], array $properties = [])
    {
        $this
            ->setProperties($properties)
            ->setAttributes($attributes);
    }

    /**
     * Set attributes
     *
     * @param array $attributes
     * @return \pwf\components\datamapper\abstraction\Model
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
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
     * Get all dirty attributes
     *
     * @return array
     */
    public function getDirtyAttributes()
    {
        return $this->dirtyAttributes;
    }

    /**
     * Set attribute
     *
     * @param string $name
     * @param string $value
     * @return \pwf\components\datamapper\abstraction\Model
     */
    public function setAttribute($name, $value)
    {
        if ($this->propertyExists($name)) {
            $this->attributes[$name] = $value;
        } else {
            $this->setDirtyAttribute($name, $value);
        }
        return $this;
    }

    /**
     * Get attribute by name
     *
     * @param string $name
     * @return string
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
     * Set dorty attribute
     *
     * @param string $name
     * @param mixed $value
     * @return \pwf\components\datamapper\abstraction\Model
     */
    public function setDirtyAttribute($name, $value)
    {
        $this->dirtyAttributes[$name] = $value;
        return $this;
    }

    /**
     * Get dirty attribute
     *
     * @param string $name
     * @return mixed
     */
    public function getDirtyAttribute($name)
    {
        $result = null;

        if ($this->dirtyAttributeExists($name)) {
            $result = $this->dirtyAttributes[$name];
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
     * Is dirty attribute exists
     *
     * @param string $name
     * @return bool
     */
    public function dirtyAttributeExists($name)
    {
        return isset($this->dirtyAttributes[$name]);
    }

    /**
     * Set available properties
     *
     * @param array $properties
     * @return \pwf\components\datamapper\abstraction\Model
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * Get available properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Check property exists
     *
     * @param string $name
     * @return bool
     */
    public function propertyExists($name)
    {
        $properties = $this->getProperties();
        return empty($properties) || in_array($name, $properties);
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
        if ($this->dirtyAttributeExists($name)) {
            return $this->getDirtyAttribute($name);
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
        return $this->dirtyAttributeExists($name) || ($this->propertyExists($name)
            && $this->attributeExists($name));
    }

    /**
     * Unset attribute
     *
     * @param string $name
     */
    public function __unset($name)
    {
        if ($this->propertyExists($name)) {
            $this->setAttribute($name, null);
            return;
        }
        if ($this->dirtyAttributeExists($name)) {
            $this->setDirtyAttribute($name, null);
            return;
        }
    }
}