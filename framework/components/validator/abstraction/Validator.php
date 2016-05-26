<?php

namespace pwf\components\validator\abstraction;

abstract class Validator implements \pwf\components\validator\interfaces\Validator
{
    /**
     * validation rules
     *
     * @var array
     */
    private $rules;

    public function __construct()
    {
        $this->setRules([]);
    }

    /**
     * Set validation rules
     *
     * @param array $rules
     * @return \pwf\components\validator\abstraction\Validator
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }
}