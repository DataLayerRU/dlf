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
    public function translate($alias, array $params = array())
    {
        $result = '';

        $values = $this->getMap();
        if (isset($values[$this->getLanguage()][$alias])) {
            $result = $values[$this->getLanguage()][$alias];
            foreach ($params as $key => $value) {
                $result = str_replace('{'.$key.'}', $value, $result);
            }
        }

        return $result;
    }
}