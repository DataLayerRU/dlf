<?php

namespace pwf\components\validator;

class Validator extends \pwf\components\validator\abstraction\Validator
{
//    private $validators = [];

    /**
     * @inheritdocs
     */
    public function validate($data)
    {
        $result = true;
        $data   = (array) $data;

        foreach ($this->getRules() as $rule) {
            $fieldsNames = (array) $rule[1];
            foreach ($fieldsNames as $field) {
                $result&=$this->validateByType($rule, $data[$field]);
            }
        }

        return $result;
    }

    protected function validateByType($rule, $data)
    {
        $result    = true;
        if (($validator = $this->getSubValidator($rule[0])) !== null) {
            $result = $validator->validate($data);
        }
        return $result;
    }

//    public function addSubValidator($type, interfaces\Validator $subValidator)
//    {
//        $this->validators[$type] = $subValidator;
//        return $this;
//    }
//
//    public function getSubValidator($type)
//    {
//        $result = null;
//        if (isset($this->validators[$type])) {
//            $result = $this->validators[$type];
//        }
//        return $result;
//    }
//
//    public function removeSubValidator($type)
//    {
//        unset($this->validators[$type]);
//    }
}