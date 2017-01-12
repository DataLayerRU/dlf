<?php

namespace pwf\components\i18n;

class ArrayTranslator extends \pwf\components\i18n\abstraction\ArrayTranslator
{

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
            $result = $values[$this->getLanguage()][$alias];
        }
        if (isset($values[$alias])) {
            $result = $values[$alias];
        }

        return $result;
    }
}