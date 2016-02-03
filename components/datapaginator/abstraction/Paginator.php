<?php

namespace pwf\components\datapaginator\abstraction;

abstract class Paginator implements \pwf\components\datapaginator\interfaces\Paginator
{
    /**
     * Current page number
     *
     * @var int
     */
    private $page;

    /**
     * Items per page
     *
     * @var int
     */
    private $limit;

    /**
     * Set current page number
     *
     * @param int $page
     * @return \pwf\components\datapaginator\abstraction\Paginator
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Get current page number
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set limit
     *
     * @param int $limit
     * @return \pwf\components\datapaginator\abstraction\Paginator
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Get limit
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }
}