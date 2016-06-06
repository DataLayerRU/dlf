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
                if (is_array($conditions[1])) {
                    $result = $conditions[0].' IN ('.implode(',', $conditions[1]).')';
                } elseif (is_null($conditions[1])) {
                    $result = $conditions[0].' IS NULL';
                } elseif ($conditions[1] instanceof \pwf\components\querybuilder\interfaces\SelectBuilder) {
                    $result = $conditions[0].' IN ('.$conditions[1]->generate().')';
                    $this->setParams(array_merge($this->getParams(),
                            $conditions[1]->getParams()));
                } else {
                    $result = $conditions[0].'=:'.$conditions[0];
                    $this->addParam($conditions[0], $conditions[1]);
                }
                break;
            case 3:
                $result = ' '.$conditions[0].' '.$this->prepareConditions([$conditions[1] => $conditions[2]]);
                break;
            default:
                throw new \Exception('Wrong condition configuration');
        }

        return $result;
    }

    protected function prepareConditions(array $conditions)
    {
        $result = '';

        foreach ($conditions as $key => $value) {
            if (is_string($key)) {
                $value = [$key, $value];
            }
            $condition = $this->prepareArray((array) $value);

            if ($result != '' && count($value) < 3) {
                $result.=' AND ';
            }
            $result.=$condition;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        return $this->prepareConditions($this->getCondition());
    }
}