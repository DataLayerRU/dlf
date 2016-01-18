<?php

namespace dlf\components\datamapper\abstraction;

abstract class Model implements \dlf\components\datamapper\interfaces\Model
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
     * @return \dlf\components\datamapper\abstraction\Model
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
     * @return \dlf\components\datamapper\abstraction\Model
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
}