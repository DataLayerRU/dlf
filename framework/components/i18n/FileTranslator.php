<?php

namespace pwf\components\i18n;

class FileTranslator extends \pwf\components\i18n\abstraction\FileTranslator
{

    use traits\ParamReplace;
    /**
     * Loaded values
     *
     * @var array
     */
    private $values;

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
        $values = $this->getValues();
        if (isset($values[$alias])) {
            $result = $this->prepareValue($values[$alias]);
        }
        return $result;
    }

    /**
     * Get values
     *
     * @return array
     */
    protected function getValues()
    {
        $result = $this->values;

        if ($result === null && file_exists($this->getDir().$this->getLanguage().'.php')) {
            $result       = $this->values = include $this->getDir().$this->getLanguage().'.php';
        }

        return $result;
    }
}