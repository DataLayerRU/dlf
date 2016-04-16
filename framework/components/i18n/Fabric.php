<?php

declare(strict_types = 1);

namespace pwf\components\i18n;

use pwf\basic\db\QueryBuilder;
use pwf\components\i18n\interfaces\Translator as ITranslator;

class Fabric
{

    /**
     * Get translator by type
     *
     * @param string $type
     * @param array $params
     * @return ITranslator
     * @throws \Exception
     */
    public function getTranslator(string $type, array $params = []): ITranslator
    {
        $result = null;

        if (!isset($params['language'])) {
            throw new \Exception('Need \'language\' param');
        }
        switch ($type) {
            case ITranslator::TRANSLATOR_FILE:
                $result = new FileTranslator();
                if (!isset($params['dir'])) {
                    throw new \Exception('Need \'dir\' param');
                }
                $result->setDir($params['dir']);
                $result->setLanguage($params['language']);
                break;
            case ITranslator::TRANSLATOR_ARRAY:
                $result = new ArrayTranslator();
                if (!isset($params['map'])) {
                    throw new \Exception('Need \'map\' param');
                }
                $result->setMap($params['map']);
                $result->setLanguage($params['language']);
                break;
            case ITranslator::TRANSLATOR_DB:
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
                if (!isset($params['connection'])) {
                    throw new \Exception('Need \'connection\' param');
                }
                $result->setAliasFieldName($params['aliasFieldName']);
                $result->setResultFieldName($params['resultFieldName']);
                $result->setTableName($params['table']);
                $result->setLanguageFieldName($params['languageFieldName']);
                $result->setQueryBuilder(QueryBuilder::select()
                    ->setConditionBuilder(QueryBuilder::getConditionBuilder()));
                $result->setConnection(is_string($params['connection']) ? \pwf\basic\Application::$instance->getComponent($params['connection'])
                    : $params['connection']);
                $result->setLanguage($params['language']);
                break;
        }

        return $result;
    }
}