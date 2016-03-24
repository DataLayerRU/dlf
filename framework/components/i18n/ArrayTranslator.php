<?php

namespace pwf\components\i18n;

class ArrayTranslator extends \pwf\components\i18n\abstraction\ArrayTranslator
{

    use traits\ParamReplace;

    /**
     * Translate string
     *
     * @param string $alias
     * @param array $params
     * @return string
     */
    public function translate($alias, array $params = [])
    {
        $result = '';

        $values = $this->getMap();
        if (isset($values[$this->getLanguage()][$alias])) {
            $result = $this->prepareValue($values[$this->getLanguage()][$alias], $params);
        }

        return $result;
    }
}