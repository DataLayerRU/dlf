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
     * Get param name
     *
     * @var string
     */
    private $pageGetParam = 'page';

    /**
     * Set current page number
     *
     * @param int $page
     * @return \pwf\components\datapaginator\abstraction\Paginator
     */
    public function setPage($page)
    {
        $this->page = (int) $page;
        return $this;
    }

    /**
     * Get current page number
     *
     * @return int
     */
    public function getPage()
    {
        if (empty($this->page) && ($paramName = $this->getParamName()) != '') {
            $this->setPage(\pwf\basic\Application::$instance->getRequest()->get($paramName));
        }

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

    /**
     * Set param name
     *
     * @param string $paramName
     * @return \pwf\components\datapaginator\abstraction\Paginator
     */
    public function setParamName($paramName)
    {
        $this->pageGetParam = $paramName;
        return $this;
    }

    /**
     * Get param name
     *
     * @return string
     */
    public function getParamName()
    {
        return $this->pageGetParam;
    }
}