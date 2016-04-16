<?php

declare(strict_types = 1);

namespace pwf\components\datapaginator\interfaces;

interface Paginator
{

    /**
     * Set current page number
     *
     * @param int $page
     * @return Paginator
     */
    public function setPage(int $page): Paginator;

    /**
     * Set items per page
     *
     * @param int $limit
     * @return Paginator
     */
    public function setLimit(int $limit): Paginator;

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array;
}