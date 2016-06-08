<?php

namespace pwf\basic\db;

class QueryBuilder
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

    /**
     * Get query builder
     *
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
     * @throws \Exception
     */
    public static function select()
    {
        $result = null;

        switch (static::getDriver()) {
            case self::DRIVER_MYSQL:
                $result = new \pwf\components\querybuilder\adapters\MySQL\SelectBuilder();
                break;
            case self::DRIVER_PG:
                $result = new \pwf\components\querybuilder\adapters\PostgreSQL\SelectBuilder();
                break;
            default:
                throw new \Exception('Wrong query builder driver');
        }

        return $result;
    }

    /**
     * Get insert builder
     *
     * @return \pwf\components\querybuilder\interfaces\InsertBuilder
     * @throws \Exception
     */
    public static function insert()
    {
        $result = null;

        switch (static::getDriver()) {
            case self::DRIVER_MYSQL:
                $result = new \pwf\components\querybuilder\adapters\MySQL\InsertBuilder();
                break;
            case self::DRIVER_PG:
                $result = new \pwf\components\querybuilder\adapters\PostgreSQL\InsertBuilder();
                break;
            default:
                throw new \Exception('Wrong query builder driver');
        }

        return $result;
    }

    /**
     * Get update builder
     *
     * @return \pwf\components\querybuilder\interfaces\UpdateBuilder
     * @throws \Exception
     */
    public static function update()
    {
        $result = null;

        switch (static::getDriver()) {
            case self::DRIVER_MYSQL:
                $result = new \pwf\components\querybuilder\adapters\MySQL\UpdateBuilder();
                break;
            case self::DRIVER_PG:
                $result = new \pwf\components\querybuilder\adapters\PostgreSQL\UpdateBuilder();
                break;
            default:
                throw new \Exception('Wrong query builder driver');
        }

        return $result;
    }

    /**
     * Get delete builder
     *
     * @return \pwf\components\querybuilder\interfaces\DeleteBuilder
     * @throws \Exception
     */
    public static function delete()
    {
        $result = null;

        switch (static::getDriver()) {
            case self::DRIVER_MYSQL:
                $result = new \pwf\components\querybuilder\adapters\MySQL\DeleteBuilder();
                break;
            case self::DRIVER_PG:
                $result = new \pwf\components\querybuilder\adapters\PostgreSQL\DeleteBuilder();
                break;
            default:
                throw new \Exception('Wrong query builder driver');
        }

        return $result;
    }

    /**
     * Get condition builder
     *
     * @return \pwf\components\querybuilder\adapters\SQL\ConditionBuilder
     */
    public static function getConditionBuilder()
    {
        $result = null;

        switch (static::getDriver()) {
            default:
                $result = new \pwf\components\querybuilder\adapters\SQL\ConditionBuilder();
        }

        return $result;
    }
}