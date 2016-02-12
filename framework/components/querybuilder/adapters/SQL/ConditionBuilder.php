<?php

namespace pwf\components\querybuilder\adapters\SQL;

class ConditionBuilder extends \pwf\components\querybuilder\abstraction\ConditionBuilder
{

    use \pwf\components\querybuilder\traits\ConditionBuilder;

    /**
     * Array to string
     *
     * @param array $conditions
     * @return string
     */
    protected function prepareArray(array $conditions)
    {
        $result = '';

        switch (count($conditions)) {
            case 1:
                $result = $conditions[0];
                break;
            case 2:
                $result = $conditions[0].'='.$conditions[1];
                break;
            case 3:
                $left   = is_array($conditions[1]) ? $this->prepareArray($conditions[1])
                        : $conditions[1];
                $right  = is_array($conditions[2]) ? $this->prepareArray($conditions[2])
                        : $conditions[2];
                $result = $left.' '.$conditions[0].' '.$right;
                break;
            default:
                throw new \Exception('Wrong condition configuration');
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $result = '';

        $params = $this->getParams();

        foreach ($params as $value) {
            if (is_array($value)) {
                $value = $this->prepareArray($value);
            }
            if ($result != '') {
                $result.=' AND ';
            }
            $result.=$value;
        }

        return $result;
    }
}