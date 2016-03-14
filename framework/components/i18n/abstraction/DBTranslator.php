<?php

namespace pwf\components\i18n\abstraction;

use pwf\components\dbconnection\interfaces\Connection;

abstract class DBTranslator extends Translator implements \pwf\components\i18n\interfaces\DBTranslator
{
    /**
     * DB connection
     *
     * @var \pwf\components\dbconnection\interfaces\Connection
     */
    private $connection;

    /**
     * Select builder
     *
     * @var \pwf\components\querybuilder\interfaces\SelectBuilder
     */
    private $queryBuilder;

    /**
     * Table name
     *
     * @var string
     */
    private $tableName;

    /**
     * Alias field name
     *
     * @var string
     */
    private $aliasFieldName;

    /**
     * Result field name
     *
     * @var string
     */
    private $resultFieldName;

    /**
     * Language field name
     *
     * @var string
     */
    private $languageFieldName;

    /**
     * Set connection
     *
     * @param Connection $connection
     * @return \pwf\components\i18n\abstraction\DBTranslator
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * Get connection
     *
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set query builder
     *
     * @param \pwf\components\querybuilder\interfaces\SelectBuilder $builder
     */
    public function setQueryBuilder(\pwf\components\querybuilder\interfaces\SelectBuilder $builder)
    {
        $this->queryBuilder = $builder;
        return $this;
    }

    /**
     * Get query builder
     *
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * Set table name
     *
     * @param string $tableName
     * @return DBTranslator
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Set alias field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setAliasFieldName($fieldName)
    {
        $this->aliasFieldName = $fieldName;
        return $this;
    }

    /**
     * Get alias field name
     *
     * @return string
     */
    public function getAliasFieldName()
    {
        return $this->aliasFieldName;
    }

    /**
     * Set result field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setResultFieldName($fieldName)
    {
        $this->resultFieldName = $fieldName;
        return $this;
    }

    /**
     * Get result field name
     *
     * @return string
     */
    public function getResultFieldName()
    {
        return $this->resultFieldName;
    }

    /**
     * Set language field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setLanguageFieldName($fieldName)
    {
        $this->languageFieldName = $fieldName;
        return $this;
    }

    /**
     * Get language field name
     *
     * @return string
     */
    public function getLanguageFieldName()
    {
        return $this->languageFieldName;
    }
}