<?php

namespace pwf\components\datamapper\traits;

trait ErrorTrait
{

    /**
     * Add error
     *
     * @param string $attribute
     * @param string $message
     * @return $this
     */
    public function addError($attribute, $message)
    {
        $this->errors[$attribute] = $message;
        return $this;
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