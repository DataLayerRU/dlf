<?php

namespace pwf\basic;

abstract class Model implements \pwf\basic\interfaces\Model
{
    /**
     * Attributes
     *
     * @var array
     */
    private $attributes;

    /**
     * validation errors
     *
     * @var array
     */
    private $errors;

    public function __construct($attributes = [])
    {
        $this->setAttributes($attributes);
        $this->errors = [];
    }

    /**
     * Set all attributes
     *
     * @param array $attributes
     */
    public function setAttributes($attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Append attributes
     *
     * @param array $attributes
     */
    public function appendAttributes($attributes = [])
    {
        $this->setAttributes(array_merge($this->attributes, $attributes));
    }

    /**
     * Get all attributes
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
     * @param string $value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Get attribute by name
     *
     * @param string $name
     * @return string
     */
    public function getAttribute($name)
    {
        $result = '';

        if ($this->attributeExists($name)) {
            $result = $this->attributes[$name];
        }

        return $result;
    }

    /**
     * is attribute exists
     *
     * @param string $name
     * @return string
     */
    public function attributeExists($name)
    {
        return isset($this->attributes[$name]) && !empty($this->attributes[$name]);
    }

    /**
     * Add error
     *
     * @param string $attribute
     * @param string $message
     */
    public function addError($attribute, $message)
    {
        $this->errors[$attribute] = $message;
    }

    /**
     * Get error by attribute name
     *
     * @param string $attribute
     * @return string
     */
    public function getError($attribute)
    {
        $result = null;

        if ($this->isErrorExists($attribute)) {
            $result = $this->errors[$attribute];
        }

        return $result;
    }

    /**
     * Check is error exists
     *
     * @param string $attribute
     * @return bool
     */
    public function isErrorExists($attribute)
    {
        return isset($this->errors[$attribute]);
    }

    /**
     * Check errors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }
}