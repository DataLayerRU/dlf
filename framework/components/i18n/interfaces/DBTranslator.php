<?php

declare(strict_types = 1);

namespace pwf\components\i18n\interfaces;

interface DBTranslator extends Translator
{

    /**
     * Set connection to DB
     *
     * @param \pwf\components\dbconnection\interfaces\Connection $connection
     * @return DBTranslator
     */
    public function setConnection(\pwf\components\dbconnection\interfaces\Connection $connection): DBTranslator;

    /**
     * Set query builder
     *
     * @param \pwf\components\querybuilder\interfaces\SelectBuilder $builder
     * @return DBTranslator
     */
    public function setQueryBuilder(\pwf\components\querybuilder\interfaces\SelectBuilder $builder): DBTranslator;

    /**
     * Set table name
     *
     * @param string $tableName
     * @return DBTranslator
     */
    public function setTableName(string $tableName): DBTranslator;

    /**
     * Set alias field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setAliasFieldName(string $fieldName): DBTranslator;

    /**
     * Set result field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setResultFieldName(string $fieldName): DBTranslator;

    /**
     * Set language field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setLanguageFieldName(string $fieldName): DBTranslator;
}