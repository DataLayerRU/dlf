<?php

namespace pwf\components\i18n\interfaces;

interface DBTranslator extends Translator
{

    /**
     * Set connection to DB
     *
     * @param \pwf\components\dbconnection\interfaces\Connection $connection
     * @return DBTranslator
     */
    public function setConnection(\pwf\components\dbconnection\interfaces\Connection $connection);

    /**
     * Set query builder
     *
     * @param \pwf\components\querybuilder\interfaces\SelectBuilder $builder
     */
    public function setQueryBuilder(\pwf\components\querybuilder\interfaces\SelectBuilder $builder);

    /**
     * Set table name
     *
     * @param string $tableName
     * @return DBTranslator
     */
    public function setTableName($tableName);

    /**
     * Set alias field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setAliasFieldName($fieldName);

    /**
     * Set result field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setResultFieldName($fieldName);

    /**
     * Set language field name
     *
     * @param string $fieldName
     * @return DBTranslator
     */
    public function setLanguageFieldName($fieldName);
}