<?php

namespace pwf\basic\db;

abstract class DBModel extends \pwf\components\activerecord\Model implements \pwf\components\querybuilder\interfaces\SelectBuilder,
    \pwf\components\querybuilder\interfaces\InsertBuilder, \pwf\components\querybuilder\interfaces\UpdateBuilder,
    \pwf\components\querybuilder\interfaces\DeleteBuilder
{

    use \pwf\components\querybuilder\traits\Conditional,
        \pwf\components\querybuilder\traits\Parameterized,
        \pwf\components\querybuilder\traits\SelectBuilder {
        \pwf\components\querybuilder\traits\Parameterized::getParams as parentGetParams;
    }

    /**
     * COnstruct
     * 
     * @param \pwf\components\dbconnection\interfaces\Connection $connection
     * @param array $attributes
     */
    public function __construct($connection, array $attributes = array())
    {
        parent::__construct($connection, $attributes);

        $this->setConditionBuilder(QueryBuilder::getConditionBuilder());
    }

    /**
     * 
     * @return type
     */
    public function count()
    {
        $builder = QueryBuilder::select()
            ->select(['COUNT('.($this->getPK()? : '*').') AS CNT'])
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere());
        return (int) $this->getConnection()
                ->query(
                    $builder->generate(),
                    array_merge($builder->getParams(), $this->getParams()))
                ->fetchColumn();
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        $builder = QueryBuilder::delete()
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere());
        return $this->getConnection()->exec(
                $builder->generate(),
                array_merge($builder->getParams(), $this->getParams()));
    }

    /**
     * @inheritdoc
     */
    public function getAll()
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
                ->fetchAll(\PDO::FETCH_ASSOC) ? : [];
    }

    /**
     * @inheritdoc
     */
    public function getOne()
    {
        $builder = QueryBuilder::select()
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere())
            ->limit(1);
        return $this->getConnection()->query(
                    $builder->generate(),
                    array_merge($builder->getParams(), $this->getParams()))
                ->fetch(\PDO::FETCH_ASSOC) ? : [];
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $result     = null;
        $id         = $this->getId();
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
            $result = $this->getConnection()->exec(QueryBuilder::insert()
                    ->table($this->getTable())
                    ->setParams($attributes)
                    ->generate(), $builder->getParams());
        }
        return $result;
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function generate()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge($this->parentGetParams(),
            $this->getConditionBuilder()->getParams());
    }
}