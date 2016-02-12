<?php

namespace pwf\components\querybuilder\abstraction;

abstract class SelectBuilder implements \pwf\components\querybuilder\interfaces\SelectBuilder
{

    /**
     * Build select part
     *
     * @return string
     */
    protected abstract function buildSelectFields();

    /**
     * Build where part
     *
     * @return string
     */
    protected abstract function buildWhere();

    /**
     * Build having part
     *
     * @return string
     */
    protected abstract function buildHaving();

    /**
     * Build join part
     *
     * @return string
     */
    protected abstract function buildJoin();

    /**
     * Build union part
     *
     * @return string
     */
    protected abstract function buildUnion();

    /**
     * Build from part
     *
     * @return string
     */
    protected abstract function buildTable();

    /**
     * Build limit part
     *
     * @return string
     */
    protected abstract function buildLimit();

    /**
     * Build group part
     *
     * @return string
     */
    protected abstract function buildGroup();

    /**
     * Generate query
     *
     * @return string
     */
    public function generate()
    {
        $result = '';

        $table  = $this->buildTable();
        $select = $this->buildSelectFields();
        $where  = $this->buildWhere();
        $having = $this->buildHaving();
        $join   = $this->buildJoin();
        $limit  = $this->buildLimit();
        $group  = $this->buildGroup();
        $union  = $this->buildUnion();

        $result.='SELECT '.$select.' FROM '.$table;
        if ($join != '') {
            $result.=$join;
        }
        if ($where != '') {
            $result.=$where;
        }
        if ($group != '') {
            $result.=$group;
        }
        if ($limit != '') {
            $result.=$limit;
        }
        if ($having != '') {
            $result.=$having;
        }
        if ($union != '') {
            $result = '('.$result.')'.$union;
        }

        return $result;
    }
}