<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\interfaces;

interface Conditional
{
    /**
     * Add condition
     *
     * @param array $condition
     * @return Conditional
     */
    public function where(array $condition): Conditional;
}