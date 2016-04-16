<?php

declare(strict_types = 1);

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
        self::$joinTypes[self::JOIN_LEFT | self::JOIN_OUTER] = 'LEFT OUTER JOIN';
        self::$joinTypes[self::JOIN_RIGHT | self::JOIN_OUTER] = 'RIGHT OUTER JOIN';
    }

    /**
     * @inheritdoc
     */
    protected function buildGroup(): string
    {
        $result = '';

        $group = $this->getGroup();
        if (count($group) > 0) {
            $result .= 'GROUP BY ' . implode(', ', $group);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildHaving(): string
    {
        $result = '';

        $having = $this->getConditionBuilder()
            ->setCondition($this->getHaving())
            ->generate();

        if ($having != '') {
            $result .= 'HAVING ' . $having;
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildJoin(): string
    {
        $result = '';

        $joins = $this->getJoin();

        foreach ($joins as $joinInfo) {
            if ($result != '') {
                $result .= ' ';
            }
            $result .= self::$joinTypes[$joinInfo['jointType']] . ' ' . $joinInfo['table'] . ' ON ' . $joinInfo['condition'];
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildLimit(): string
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
    protected function buildSelectFields(): string
    {
        $fields = (array)$this->getSelect();
        array_walk($fields,
            function (&$value, $key) {
                if (is_string($key)) {
                    $value = $key . ' AS ' . $value;
                }
            });
        return implode(',', $fields);
    }

    /**
     * @inheritdoc
     */
    protected function buildTable(): string
    {
        return $this->getTable();
    }

    /**
     * @inheritdoc
     */
    protected function buildUnion(): string
    {
        $result = '';

        $union = $this->getUnion();

        foreach ($union as $query) {
            $result .= ' UNION (' . $query->generate() . ')';
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function buildWhere(): string
    {
        $result = '';

        $having = $this->getConditionBuilder()
            ->setCondition($this->getWhere())
            ->generate();

        if ($having != '') {
            $result .= 'WHERE ' . $having;
        }

        return $result;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->getConditionBuilder()->getParams();
    }
}