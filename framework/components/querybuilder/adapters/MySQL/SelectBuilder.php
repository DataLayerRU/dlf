<?php

namespace pwf\components\querybuilder\adapters\MySQL;

class SelectBuilder extends \pwf\components\querybuilder\abstraction\SelectBuilder
{

    use \pwf\components\querybuilder\traits\SelectBuilder,
        \pwf\components\querybuilder\traits\Conditional;
    /**
     * Join types
     *
     * @var array
     */
    public static $joinTypes = [
        self::JOIN_LEFT => 'LEFT JOIN',
        self::JOIN_RIGHT => 'RIGHT JOIN',
        self::JOIN_CROSS => 'CROSS JOIN',
        self::JOIN_INNER => 'INNER JOIN'
    ];

    public function __construct()
    {
        self::$joinTypes[self::JOIN_LEFT | self::JOIN_OUTER]  = 'LEFT OUTER JOIN';
        self::$joinTypes[self::JOIN_RIGHT | self::JOIN_OUTER] = 'RIGHT OUTER JOIN';
    }

    /**
     * @inheritdoc
     */
    protected function buildGroup()
    {
        $result = '';

        $group = $this->getGroup();
        if (count($group) > 0) {
            $result.='GROUP BY '.implode(', ', $group);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildHaving()
    {
        $result = '';

        $having = $this->getConditionBuilder()
            ->setCondition($this->getHaving())
            ->generate();

        if ($having != '') {
            $result.='HAVING '.$having;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildJoin()
    {
        $result = '';

        $joins = $this->getJoin();

        foreach ($joins as $joinInfo) {
            if ($result != '') {
                $result.=' ';
            }
            $result.=self::$joinTypes[$joinInfo['jointType']].' '.$joinInfo['table'].' ON '.$joinInfo['condition'];
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildLimit()
    {
        $result = '';

        if (($offset = $this->getOffset()) > 0) {
            $result.=$offset.', ';
        }
        if (($limit = $this->getLimit()) > 0) {
            $result.=$limit;
        }
        if ($result != '') {
            $result = 'LIMIT '.$result;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildSelectFields()
    {
        $fields = (array) $this->getSelect();
        array_walk($fields,
            function(&$value, $key) {
            if (is_string($key)) {
                $value = $key.' AS '.$value;
            }
        });
        return implode(',', $fields);
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
    protected function buildUnion()
    {
        $result = '';

        $union = $this->getUnion();

        foreach ($union as $query) {
            $result.=' UNION ('.$query->generate().')';
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildWhere()
    {
        $result = '';

        $having = $this->getConditionBuilder()
            ->setCondition($this->getWhere())
            ->generate();

        if ($having != '') {
            $result.='WHERE '.$having;
        }

        return $result;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->getConditionBuilder()->getParams();
    }

    /**
     * Build order
     * 
     * @return string
     */
    protected function buildOrder()
    {
        $result = '';

        $orders = (array) $this->getOrder();
        foreach ($orders as $field => $direction) {
            if ($result != '') {
                $result.=',';
            }
            $result.=$field.' '.($direction === SORT_DESC ? 'DESC' : 'ASC');
        }
        if ($result != '') {
            $result = 'ORDER BY '.$result;
        }

        return $result;
    }
}