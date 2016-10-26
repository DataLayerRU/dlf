<?php

namespace pwf\components\datapaginator\interfaces;

/**
 * For paginatable datasource
 */
interface Paginatable extends \pwf\components\datamapper\interfaces\Getter
{

    /**
     * Set limit
     *
     * @param int $limit
     */
    public function limit($limit);

    /**
     * Set offset
     *
     * @param int $offset
     */
    public function offset($offset);
}