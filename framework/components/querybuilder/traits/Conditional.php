<?php

namespace pwf\components\querybuilder\traits;

trait Conditional
{
    /**
     * Condition builder
     *
     * @var \pwf\components\querybuilder\interfaces\ConditionBuilder
     */
    private $conditionBuilder;

    /**
     * Set condition builder
     *
     * @param \pwf\components\querybuilder\interfaces\ConditionBuilder $builder
     * @return $this
     */
    public function setConditionBuilder(\pwf\components\querybuilder\interfaces\ConditionBuilder $builder)
    {
        $this->conditionBuilder = $builder;
        return $this;
    }

    /**
     * Get condition builder
     *
     * @return \pwf\components\querybuilder\interfaces\ConditionBuilder
     */
    public function getConditionBuilder()
    {
        return $this->conditionBuilder;
    }
}