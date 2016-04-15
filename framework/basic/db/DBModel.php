<?php

declare(strict_types = 1);

namespace pwf\basic\db;

use pwf\components\datamapper\interfaces\Getter;
use pwf\components\dbconnection\interfaces\Connection;
use \pwf\components\querybuilder\traits\{
    Conditional, Parameterized, SelectBuilder
};
use pwf\components\querybuilder\interfaces\{
    SelectBuilder as ISelectBuilder, InsertBuilder, UpdateBuilder
};

abstract class DBModel extends \pwf\components\activerecord\Model implements ISelectBuilder,
    InsertBuilder, UpdateBuilder
{

    use Conditional,
        Parameterized,
        SelectBuilder {
        Parameterized::getParams as parentGetParams;
    }

    /**
     * Construct
     *
     * @param \pwf\components\dbconnection\interfaces\Connection $connection
     * @param array $attributes
     */
    public function __construct(Connection $connection, array $attributes = array())
    {
        parent::__construct($connection, $attributes);

        $this->setConditionBuilder(QueryBuilder::getConditionBuilder());
    }

    /**
     * Count records
     *
     * @return int
     */
    public function count(): int
    {
        return (int)$this->getConnection()
            ->query(QueryBuilder::select()
                ->select(['COUNT(' . $this->getPK() . ') AS CNT'])
                ->table($this->getTable())
                ->setConditionBuilder($this->getConditionBuilder())
                ->where($this->getWhere())
                ->generate(), $this->getParams())
            ->fetchColumn();
    }

    /**
     * @inheritdoc
     */
    public function delete(): bool
    {
        return $this->getConnection()->exec(QueryBuilder::delete()
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere())
            ->generate(), $this->getParams());
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        return $this->getConnection()->query(QueryBuilder::select()
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere())
            ->limit($this->getLimit())
            ->offset($this->getOffset())
            ->generate(), $this->getParams());
    }

    /**
     * @inheritdoc
     */
    public function getOne(): Getter
    {
        return $this->getConnection()->query(
            QueryBuilder::select()
                ->table($this->getTable())
                ->setConditionBuilder($this->getConditionBuilder())
                ->where($this->getWhere())
                ->limit(1)
                ->generate(), $this->getParams());
    }

    /**
     * @inheritdoc
     */
    public function save(): bool
    {
        $result = null;
        $id = $this->getId();
        if (!empty($id)) {
            $result = $this->getConnection()->exec(QueryBuilder::update()
                ->table($this->getTable())
                ->setConditionBuilder($this->getConditionBuilder())
                ->where([
                    $this->getPK() => $this->getId()
                ])
                ->setParams($this->getAttributes())
                ->generate(), $this->getParams());
        } else {
            $result = $this->getConnection()->exec(QueryBuilder::insert()
                ->table($this->getTable())
                ->setParams($this->getAttributes())
                ->generate(), $this->getParams());
        }
        return $result;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function generate(): string
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @inheritdoc
     */
    public function getParams(): array
    {
        return array_merge($this->parentGetParams(),
            $this->getConditionBuilder()->getParams());
    }
}