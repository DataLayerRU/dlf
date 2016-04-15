<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\traits;

trait Parameterized
{
    /**
     * Params
     *
     * @var array
     */
    private $params = [];

    /**
     * Set params
     *
     * @param array $params
     * @return \pwf\components\querybuilder\interfaces\ConditionBuilder
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Add param
     *
     * @param string $name
     * @param mixed $value
     * @return \pwf\components\querybuilder\interfaces\ConditionBuilder
     */
    public function addParam(string $name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}