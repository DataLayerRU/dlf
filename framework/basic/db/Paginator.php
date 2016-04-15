<?php

declare(strict_types = 1);

namespace pwf\basic\db;

class Paginator extends \pwf\components\datapaginator\abstraction\Paginator
{
    /**
     * Data source
     *
     * @var \pwf\basic\db\DBModel
     */
    private $dataSource;

    /**
     * Set data source
     *
     * @param \pwf\basic\db\DBModel $dataSource
     * @return \pwf\components\datamapper\Paginator
     */
    public function setDataSource(\pwf\basic\db\DBModel $dataSource): Paginator
    {
        $this->dataSource = $dataSource;
        return $this;
    }

    /**
     * Get data source
     *
     * @return \pwf\basic\db\DBModel
     */
    public function getDataSource(): DBModel
    {
        return $this->dataSource;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        $limit = $this->getLimit();
        $this->setHeaders();
        $page = $this->getPage();
        if ($page > 0) {
            $page -= 1;
        }
        return $this->getDataSource()->limit($limit)->offset($limit * $page)->getAll();
    }

    /**
     * Set headers
     *
     * @return Paginator
     */
    protected function setHeaders(): Paginator
    {
        $cnt = $this->getDataSource()->count();
        $limit = $this->getLimit();
        if ($limit == 0) {
            $limit = 1;
        }
        \pwf\basic\Application::$instance
            ->getResponse()
            ->setHeaders([
                'x-pagination-current-page: ' . $this->getPage(),
                'x-pagination-page-count: ' . ceil($cnt / $limit),
                'x-pagination-per-page: ' . $limit,
                'x-pagination-total-count: ' . $cnt
            ]);
        return $this;
    }
}