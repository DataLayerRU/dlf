<?php

namespace pwf\components\datapaginator;

use pwf\components\datapaginator\interfaces\Paginatable;

class Paginator extends \pwf\components\datapaginator\abstraction\Paginator
{
    /**
     * Data source
     *
     * @var Paginatable
     */
    private $dataSource;

    /**
     * Set data source
     *
     * @param Paginatable $dataSource
     * @return $this
     */
    public function setDataSource(Paginatable $dataSource)
    {
        $this->dataSource = $dataSource;
        return $this;
    }

    /**
     * Get data source
     *
     * @return Paginatable
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $limit = $this->getLimit();
        $this->setHeaders();
        $page  = $this->getPage();
        if ($page > 0) {
            $page-=1;
        }
        return $this->getDataSource()->limit($limit)->offset($limit * $page)->getAll();
    }

    /**
     * Set headers
     *
     * @return $this
     */
    protected function setHeaders()
    {
        $cnt   = $this->getDataSource()->count();
        $limit = $this->getLimit();
        if ($limit == 0) {
            $limit = 1;
        }
        \pwf\basic\Application::$instance
            ->getResponse()
            ->setHeaders([
                'x-pagination-current-page: '.$this->getPage(),
                'x-pagination-page-count: '.ceil($cnt / $limit),
                'x-pagination-per-page: '.$limit,
                'x-pagination-total-count: '.$cnt
        ]);
        return $this;
    }
}