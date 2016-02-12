<?php

namespace pwf\components\querybuilder\traits;

trait ConditionBuilder
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
     * @return $this
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
     * @param string $value
     * @return $this
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}