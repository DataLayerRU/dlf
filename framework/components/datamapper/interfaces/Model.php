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
     * @return string
     */
    public function getAttribute(string $name): string;

    /**
     * Set attribute
     *
     * @param string $name
     * @param string $value
     * @return Model
     */
    public function setAttribute(string $name, string $value): Model;
}