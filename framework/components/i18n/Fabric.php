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
                $result=new DBTranslator();
                $result->setAliasFieldName($params[]);
        }

        return $result;
    }
}