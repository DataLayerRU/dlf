<?php

namespace pwf\components\querybuilder\adapters\MySQL;

class UpdateBuilder extends \pwf\components\querybuilder\abstraction\UpdateBuilder
{

    use \pwf\components\querybuilder\traits\QueryBuilder,
        \pwf\components\querybuilder\traits\Conditional,
        \pwf\components\querybuilder\traits\Parameterized {
        getParams as parentGetParams;
    }

    /**
     * @inheritdoc
     */
    protected function buildWhere()
    {
        $result = '';

        $where = $this->getConditionBuilder()
            ->setCondition($this->getWhere())
            ->generate();

        if ($where != '') {
            $result.='WHERE '.$where;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildFields()
    {
        $result = '';

        $fields = array_keys($this->parentGetParams());
        foreach ($fields as $value) {
            if ($result != '') {
                $result.=', ';
            }
            $result.=$value.'=:'.$value;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildTable()
    {
        return $this->getTable();
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge($this->parentGetParams(),
            $this->getConditionBuilder()->getParams());
    }
}