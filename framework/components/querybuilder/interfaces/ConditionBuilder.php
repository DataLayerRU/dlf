<?php

namespace pwf\components\querybuilder\interfaces;

interface ConditionBuilder
{

    /**
     * Generate query
     *
     * @return string
     */
    public function generate();

    /**
     * Set params
     *
     * @param array $params
     * @return ConditionBuilder
     */
    public function setParams(array $params);
}