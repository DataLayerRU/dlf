<?php

declare(strict_types = 1);

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
    public function translate(string $alias, array $params = []): string
    {
        $result = '';
        $values = $this->getValues();
        if (isset($values[$alias])) {
            $result = $this->prepareValue($values[$alias], $params);
        }
        return $result;
    }

    /**
     * Get values
     *
     * @return array
     */
    protected function getValues(): array
    {
        $result = $this->values;

        if ($result === null && file_exists($this->getDir() . $this->getLanguage() . '.php')) {
            $result = $this->values = include $this->getDir() . $this->getLanguage() . '.php';
        }

        return $result;
    }
}