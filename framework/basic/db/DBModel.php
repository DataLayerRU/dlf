<?php

namespace pwf\basic\db;

abstract class DBModel extends \pwf\components\activerecord\Model implements \pwf\components\querybuilder\interfaces\SelectBuilder,
    \pwf\components\querybuilder\interfaces\InsertBuilder, \pwf\components\querybuilder\interfaces\UpdateBuilder,
    \pwf\components\querybuilder\interfaces\DeleteBuilder
{
    /**
     * Sequence name
     *
     * @var string
     */
    private $sequenceName;

    use \pwf\components\querybuilder\traits\Conditional,
        \pwf\components\querybuilder\traits\Parameterized,
        \pwf\traits\Validatable,
        \pwf\components\querybuilder\traits\SelectBuilder {
        \pwf\components\querybuilder\traits\Parameterized::getParams as parentGetParams;
        \pwf\traits\Validatable::validate as parentValidate;
    }

    /**
     * COnstruct
     * 
     * @param \pwf\components\dbconnection\interfaces\Connection $connection
     * @param array $attributes
     */
    public function __construct($connection, array $attributes = [],
                                array $properties = [])
    {
        parent::__construct($connection, $attributes, $properties);

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
            ->select($this->getSelect())
            ->setJoins($this->getJoin())
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere())
            ->limit($this->getLimit())
            ->offset($this->getOffset())
            ->order($this->getOrder());
        return $this->fillObjects($this->getConnection()->query(
                        $builder->generate(),
                        array_merge($builder->getParams(), $this->getParams()))
                    ->fetchAll(\PDO::FETCH_ASSOC) ? : []);
    }

    /**
     * Prepare objects
     *
     * @param array $data
     * @return array
     */
    protected function fillObjects(array $data)
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = (new static())->setAttributes($item);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getOne()
    {
        $builder = QueryBuilder::select()
            ->select($this->getSelect())
            ->table($this->getTable())
            ->setConditionBuilder($this->getConditionBuilder())
            ->where($this->getWhere())
            ->limit(1);
        return $this->setAttributes($this->getConnection()->query(
                        $builder->generate(),
                        array_merge($builder->getParams(), $this->getParams()))
                    ->fetch(\PDO::FETCH_ASSOC) ? : []);
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
            $builder = QueryBuilder::insert()
                ->table($this->getTable())
                ->setParams($attributes);
            if (($result  = $this->getConnection()->exec(
                $builder->generate(), $builder->getParams()))) {
                $this->setAttribute($this->getPK(),
                    $this->getConnection()->insertId($this->getSequenceName()));
            }
        }
        return $result;
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function generate()
    {
        return QueryBuilder::select()
                ->select($this->getSelect())
                ->table($this->getTable())
                ->setConditionBuilder($this->getConditionBuilder())
                ->where($this->getWhere())
                ->limit($this->getLimit())
                ->offset($this->getOffset())
                ->generate();
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return array_merge($this->parentGetParams(),
            $this->getConditionBuilder()->getParams());
    }

    /**
     * Set sequence name
     *
     * @param string $name
     * @return \pwf\basic\db\DBModel
     */
    public function setSequenceName($name)
    {
        $this->sequenceName = $name;
        return $this;
    }

    /**
     * Get sequence name
     *
     * @return string
     */
    public function getSequenceName()
    {
        return $this->sequenceName;
    }

    /**
     * Validate model
     *
     * @return bool
     */
    public function validate()
    {
        return $this->parentValidate($this->getAttributes());
    }
}