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
        $builder = QueryBuilder::select()
            ->select(['COUNT(' . ($this->getPK() ?: '*') . ') AS CNT'])
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere());
        return (int)$this->getConnection()
            ->query(
                $builder->generate(),
                array_merge($builder->getParams(), $this->getParams()))
            ->fetchColumn();
    }

    /**
     * @inheritdoc
     */
    public function delete(): bool
    {
        $builder = QueryBuilder::delete()
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere());
        return $this->getConnection()->exec(
            $builder->generate(),
            array_merge($builder->getParams(), $this->getParams())) !== false;
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        $builder = QueryBuilder::select()
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere())
            ->limit($this->getLimit())
            ->offset($this->getOffset());
        return $this->getConnection()->query(
            $builder->generate(),
            array_merge($builder->getParams(), $this->getParams()))
            ->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * @inheritdoc
     */
    public function getOne(): array
    {
        $builder = QueryBuilder::select()
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere())
            ->limit(1);
        return $this->getConnection()->query(
            $builder->generate(),
            array_merge($builder->getParams(), $this->getParams()))
            ->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * @inheritdoc
     */
    public function save(): bool
    {
        $result = null;
        $id = $this->getId();
        $attributes = $this->getAttributes();
        unset($attributes[$this->getPK()]);
        if (!empty($id)) {
            $builder = QueryBuilder::update()
                ->table($this->getTable())
                ->setConditionBuilder($this->getConditionBuilder())
                ->where([
                    $this->getPK() => $this->getId()
                ])
                ->setParams($attributes);

            $result = $this->getConnection()->exec($builder->generate(),
                array_merge($builder->getParams(), $this->getParams()));
        } else {
            $builder = QueryBuilder::insert()
                ->table($this->getTable())
                ->setParams($attributes);
            $result = $this->getConnection()->exec(
                $builder->generate(), $builder->getParams());
        }
        return $result->rowCount() > 0;
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