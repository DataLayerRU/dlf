<?php

namespace pwf\components\i18n;

use pwf\components\i18n\interfaces\Translator;

class Fabric
{

    /**
     * Get translator by type
     *
     * @param string $type
     * @param array $params
     * @return \pwf\components\i18n\interfaces\Translator
     */
    public function getTranslator($type, array $params = [])
    {
        $result = null;

        switch ($type) {
            case Translator::TRANSLATOR_ARRAY:
                $result = new ArrayTranslator();
                $result->setMap($params['map']);
                break;
            case Translator::TRANSLATOR_DB:
                $result = new DBTranslator();
                if (!isset($params['aliasFieldName'])) {
                    throw new \Exception('Need \'aliasFieldName\' param');
                }
                if (!isset($params['languageFieldName'])) {
                    throw new \Exception('Need \'languageFieldName\' param');
                }
                if (!isset($params['resultFieldName'])) {
                    throw new \Exception('Need \'resultFieldName\' param');
                }
                if (!isset($params['table'])) {
                    throw new \Exception('Need \'table\' param');
                }
                $result->setAliasFieldName($params['aliasFieldName']);
                $result->setResultFieldName($params['resultFieldName']);
                $result->setTableName($params['table']);
                $result->setLanguageFieldName($params['languageFieldName']);
                $result->setQueryBuilder(\pwf\basic\db\QueryBuilder::select());
        }

        return $result;
    }
}