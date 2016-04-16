<?php

declare(strict_types = 1);

namespace pwf\components\querybuilder\adapters\SQL;

class ConditionBuilder extends \pwf\components\querybuilder\abstraction\ConditionBuilder
{

    use \pwf\components\querybuilder\traits\ConditionBuilder;

    /**
     * Array to string
     *
     * @param array $conditions
     * @return string
     * @throws \Exception
     */
    protected function prepareArray(array $conditions): string
    {
        $result = '';

        switch (count($conditions)) {
            case 1:
                $result = $conditions[0];
                break;
            case 2:
                $result = $conditions[0].'=:'.$conditions[0];
                $this->addParam($conditions[0], $conditions[1]);
                break;
            case 3:
                $left   = is_array($conditions[1]) ? $this->prepareConditions($conditions[1])
                        : $conditions[1];
                $right  = is_array($conditions[2]) ? $this->prepareConditions($conditions[2])
                        : $conditions[2];
                $result = $left.' '.$conditions[0].' '.$right;
                break;
            default:
                throw new \Exception('Wrong condition configuration');
        }

        return $result;
    }

    /**
     * Prepare conditions
     *
     * @param array $conditions
     * @return string
     * @throws \Exception
     */
    protected function prepareConditions(array $conditions): string
    {
        $result = '';

        foreach ($conditions as $key => $value) {
            if (is_string($key)) {
                $value = [$key, $value];
            }
            $condition = $this->prepareArray((array) $value);

            if ($result != '') {
                $result.=' AND ';
            }
            $result.=$condition;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function generate(): string
    {
        return $this->prepareConditions($this->getCondition());
    }
}