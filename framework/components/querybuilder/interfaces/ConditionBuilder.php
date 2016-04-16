<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\interfaces;

interface ConditionBuilder extends Generatable
{

    /**
     * Set params
     *
     * @param array $condition
     * @return ConditionBuilder
     */
    public function setCondition(array $condition): ConditionBuilder;

    /**
     * Get params
     *
     * @return array
     */
    public function getParams(): array;
}