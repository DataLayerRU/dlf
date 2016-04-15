<?php

declare(strict_types = 1);

namespace pwf\components\datamapper\traits;

trait ErrorTrait
{
    private $errors = [];

    /**
     * Add error
     *
     * @param string $attribute
     * @param string $message
     * @return $this
     */
    public function addError(string $attribute, string $message)
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
    public function getError(string $attribute): string
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
    public function isErrorExists(string $attribute): bool
    {
        return isset($this->errors[$attribute]);
    }

    /**
     * Check errors
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }
}