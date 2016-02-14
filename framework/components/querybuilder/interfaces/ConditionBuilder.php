<?php

namespace pwf\components\querybuilder\interfaces;

interface ConditionBuilder extends Generatable
{

    /**
     * Set params
     *
     * @param array $condition
     * @return ConditionBuilder
     */
    public function setCondition(array $condition);

    /**
     * Get params
     *
     * @return array
     */
    public function getParams();
}