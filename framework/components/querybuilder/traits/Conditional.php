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
     * Condition
     *
     * @var array
     */
    private $where = [];

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

    /**
     * Set where condition
     *
     * @param array $condition
     * @return \pwf\components\querybuilder\interfaces\ConditionBuilder
     */
    public function where(array $condition)
    {
        $this->where = array_merge($this->where, (array) $condition);
        return $this;
    }

    /**
     * Get where
     *
     * @return array
     */
    public function getWhere()
    {
        return $this->where;
    }
}