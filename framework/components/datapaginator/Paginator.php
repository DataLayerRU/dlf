<?php

namespace pwf\components\datapaginator;

use pwf\components\datapaginator\interfaces\Paginatable;

class Paginator extends \pwf\components\datapaginator\abstraction\Paginator
{
    const LIMIT = 10;

    /**
     * Data source
     *
     * @var Paginatable
     */
    private $dataSource;

    /**
     * Total quantity
     *
     * @var int
     */
    private $cnt;

    public function __construct($limit = self::LIMIT)
    {
        $this->setLimit($limit);
    }

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
        \pwf\basic\Application::$instance
            ->getResponse()
            ->setHeaders([
                'x-pagination-current-page: '.$this->getPage(),
                'x-pagination-page-count: '.$this->getPageQty(),
                'x-pagination-per-page: '.max($this->getLimit(), 1),
                'x-pagination-total-count: '.$this->count()
        ]);
        return $this;
    }

    /**
     * Count records
     *
     * @return int
     */
    public function count()
    {
        if ($this->cnt === null) {
            $this->cnt = $this->getDataSource()->count();
        }
        return $this->cnt;
    }

    /**
     * Get pages quantity
     *
     * @return int
     */
    public function getPageQty()
    {
        return ceil($this->count() / max($this->getLimit(), 1));
    }
}