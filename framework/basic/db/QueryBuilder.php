<?php

namespace pwf\basic\db;

class QueryBuilder implements \pwf\components\querybuilder\interfaces\SelectBuilder,
    \pwf\components\querybuilder\interfaces\InsertBuilder, \pwf\components\querybuilder\interfaces\UpdateBuilder
{
    /**
     * MySQL driver
     */
    const DRIVER_MYSQL = 'mysql';

    /**
     * PostgreSQL driver
     */
    const DRIVER_PG = 'pgsql';

    /**
     * Current driver
     *
     * @var string
     */
    private static $driver;

    /**
     * Current query builder
     *
     * @var \pwf\components\querybuilder\interfaces\SelectBuilder
     */
    private static $queryBuilder;

    /**
     * Insert builder
     *
     * @var \pwf\components\querybuilder\interfaces\InsertBuilder
     */
    private static $insertBuilder;

    /**
     * Update builder
     *
     * @var \pwf\components\querybuilder\interfaces\UpdateBuilder
     */
    private static $updateBuilder;

    /**
     * Set current driver
     *
     * @param string $driver
     */
    public static function setDriver($driver)
    {
        self::$driver = $driver;
    }

    /**
     * Get current driver
     *
     * @return string
     */
    public static function getDriver()
    {
        return self::$driver;
    }

    protected static function getQueryBuilder()
    {
        if (self::$queryBuilder === null) {
            switch (static::getDriver()) {
                case self::DRIVER_MYSQL:
                    self::$queryBuilder=new \pwf\components\querybuilder\adapters\MySQL\SelectBuilder();
                    break;
                case self::DRIVER_PG:
                    break;
                default:
                    throw new \Exception('Wrong query builder driver');
            }
        }
    }

    public function generate()
    {

    }

    public function getParams()
    {
        
    }

    public function group($group)
    {

    }

    public function having($condition)
    {
        
    }

    public function join($table, $condition, $joinType = self::JOIN_LEFT)
    {

    }

    public function limit($limit)
    {
        
    }

    public function offset($offset)
    {

    }

    public function select(array $fields)
    {
        
    }

    public function table($table)
    {

    }

    public function union(\pwf\components\querybuilder\interfaces\QueryBuilder $query)
    {
        
    }

    public function where($condition)
    {

    }
}