<?php

namespace pwf\traits;

use pwf\helpers\Validator;

trait Validatable
{

    use \pwf\components\datamapper\traits\ErrorTrait;
    /**
     * Validation rules
     *
     * @var array
     */
    private $rules = [];

    /**
     * Set rules
     *
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Get rules
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Validate data
     *
     * @param array $data
     * @return bool
     */
    public function validate(array $data)
    {
        $rules = $this->getRules();
        foreach ($rules as $field => $rule) {
            if ((isset($rule['required']) && $rule['required'] === true && isset($data[$field]))
                || ((!isset($rule['required']) || !$rule['required'])) && isset($data[$field])) {
                foreach ($rule as $key => $value) {
                    if ($key !== 'required') {
                        foreach ($value as $validator) {
                            if (!is_array($validator)) {
                                $validator = [$validator];
                            }
                            if (!Validator::validate($validator[0], $field,
                                    $data, $validator)) {
                                $this->addError($field,
                                    isset($rule['errorMessage']) ? $rule['errorMessage']
                                            : false);
                            }
                        }
                    }
                }
            } elseif (isset($rule['required']) && $rule['required'] === true) {
                $this->addError($field,
                    isset($rule['errorMessage']) ? $rule['errorMessage'] : false);
            }
        }
        return !$this->hasErrors();
    }
}