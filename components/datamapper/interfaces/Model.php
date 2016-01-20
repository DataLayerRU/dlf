<?php

namespace dlf\components\datamapper\interfaces;

interface Model
{
    /**
     * Get primary key
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set model attributes
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * Get attribute
     *
     * @param string $name
     */
    public function getAttribute($name);

    /**
     * Set attribute
     *
     * @param string $name
     * @param mixed $value
     */
    public function setAttribute($name, $value);
}