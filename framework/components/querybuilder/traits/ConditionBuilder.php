<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\traits;

trait ConditionBuilder
{

    use Parameterized;
    /**
     * Conditions
     *
     * @var array
     */
    private $condition = [];

    /**
     * Set params
     *
     * @param array $condition
     * @return \pwf\components\querybuilder\interfaces\ConditionBuilder
     */
    public function setCondition(array $condition): \pwf\components\querybuilder\interfaces\ConditionBuilder
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * Get conditions
     *
     * @return array
     */
    public function getCondition(): array
    {
        return $this->condition;
    }
}