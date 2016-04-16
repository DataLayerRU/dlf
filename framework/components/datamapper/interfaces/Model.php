<?php

declare(strict_types = 1);

namespace pwf\components\datamapper\interfaces;

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
     * @return Model
     */
    public function setAttributes(array $attributes): Model;

    /**
     * Get attribute
     *
     * @param string $name
     * @return mixed
     */
    public function getAttribute(string $name);

    /**
     * Set attribute
     *
     * @param string $name
     * @param mixed $value
     * @return Model
     */
    public function setAttribute(string $name, $value): Model;
}