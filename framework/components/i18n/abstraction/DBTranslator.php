<?php

declare(strict_types = 1);

namespace pwf\components\i18n\abstraction;

use pwf\components\dbconnection\interfaces\Connection;
use pwf\components\querybuilder\interfaces\SelectBuilder;

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
     * @return DBTranslator
     */
    public function setQueryBuilder(\pwf\components\querybuilder\interfaces\SelectBuilder $builder): DBTranslator
    {
        $this->queryBuilder = $builder;
        return $this;
    }

    /**
     * Get query builder
     *
     * @return \pwf\components\querybuilder\interfaces\SelectBuilder
     */
    public function getQueryBuilder(): SelectBuilder
    {
        return $this->queryBuilder;
    }

    /**
     * Set table name
     *
     * @param string $tableName
     * @return DBTranslator
     */
    public function setTableName(string $tableName): DBTranslator
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * Set alias field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setAliasFieldName(string $fieldName): DBTranslator
    {
        $this->aliasFieldName = $fieldName;
        return $this;
    }

    /**
     * Get alias field name
     *
     * @return string
     */
    public function getAliasFieldName(): string
    {
        return $this->aliasFieldName;
    }

    /**
     * Set result field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setResultFieldName(string $fieldName): DBTranslator
    {
        $this->resultFieldName = $fieldName;
        return $this;
    }

    /**
     * Get result field name
     *
     * @return string
     */
    public function getResultFieldName(): string
    {
        return $this->resultFieldName;
    }

    /**
     * Set language field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setLanguageFieldName(string $fieldName): DBTranslator
    {
        $this->languageFieldName = $fieldName;
        return $this;
    }

    /**
     * Get language field name
     *
     * @return string
     */
    public function getLanguageFieldName(): string
    {
        return $this->languageFieldName;
    }
}