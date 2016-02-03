<?php

namespace pwf\components\datamapper;

class Paginator extends \pwf\components\datapaginator\abstraction\Paginator
{
    /**
     * Data source
     *
     * @var interfaces\Getter
     */
    private $dataSource;

    /**
     * Set data source
     *
     * @param \pwf\components\datamapper\interfaces\Getter $dataSource
     * @return \pwf\components\datamapper\Paginator
     */
    public function setDataSource(interfaces\Getter $dataSource)
    {
        $this->dataSource = $dataSource;
        return $this;
    }

    /**
     * Get data source
     *
     * @return \pwf\components\datamapper\interfaces\Getter
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * Get data
     *
     * @return mixed[]
     */
    public function getData()
    {
        $limit = $this->getLimit();
        return $this->getDataSource()->getAll([], $limit,
                $limit * $this->getPage());
    }
}