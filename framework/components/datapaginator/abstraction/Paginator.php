<?php

declare(strict_types = 1);

namespace pwf\components\datapaginator\abstraction;

use pwf\components\datapaginator\interfaces\Paginator as IPaginator;

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
     * Get param name
     *
     * @var string
     */
    private $pageGetParam = 'page';

    /**
     * Set current page number
     *
     * @param int $page
     * @return IPaginator
     */
    public function setPage(int $page): IPaginator
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Get current page number
     *
     * @return int
     */
    public function getPage(): int
    {
        if (empty($this->page) && ($paramName = $this->getParamName()) != '') {
            $this->setPage((int)\pwf\basic\Application::$instance->getRequest()->get($paramName));
        }

        return $this->page;
    }

    /**
     * Set limit
     *
     * @param int $limit
     * @return IPaginator
     */
    public function setLimit(int $limit): IPaginator
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Get limit
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Set param name
     *
     * @param string $paramName
     * @return IPaginator
     */
    public function setParamName(string $paramName): IPaginator
    {
        $this->pageGetParam = $paramName;
        return $this;
    }

    /**
     * Get param name
     *
     * @return string
     */
    public function getParamName(): string
    {
        return $this->pageGetParam;
    }
}