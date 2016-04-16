<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\traits;

use pwf\components\querybuilder\interfaces\{
    Conditional as IConditional, ConditionBuilder as IConditionBuilder
};

trait Conditional
{
    /**
     * Condition builder
     *
     * @var IConditionBuilder
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
     * @param IConditionBuilder $builder
     * @return IConditional
     */
    public function setConditionBuilder(IConditionBuilder $builder): IConditional
    {
        $this->conditionBuilder = $builder;
        return $this;
    }

    /**
     * Get condition builder
     *
     * @return IConditionBuilder
     */
    public function getConditionBuilder(): IConditionBuilder
    {
        return $this->conditionBuilder;
    }

    /**
     * Set where condition
     *
     * @param array $condition
     * @return IConditional
     */
    public function where(array $condition): IConditional
    {
        $this->where = array_merge($this->where, (array)$condition);
        return $this;
    }

    /**
     * Get where
     *
     * @return array
     */
    public function getWhere(): array
    {
        return $this->where;
    }
}