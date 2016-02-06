<?php

namespace pwf\components\datapaginator\interfaces;

interface Paginator
{

    /**
     * Set current page number
     *
     * @param int $page
     * @return $this
     */
    public function setPage($page);

    /**
     * Set items per page
     *
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit);

    /**
     * Get data
     *
     * @return mixed[]
     */
    public function getData();
}