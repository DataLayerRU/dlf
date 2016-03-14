<?php

namespace pwf\components\i18n;

class Translator extends abstraction\Translator implements \pwf\basic\interfaces\Component,
    interfaces\Translator
{
    /**
     * Values in array
     */
    const TRANSLATOR_ARRAY = 'array';

    /**
     * Values in DB
     */
    const TRANSLATOR_DB = 'db';

    /**
     * Values in files
     */
    const TRANSLATOR_FILE = 'file';

    /**
     * Translators
     *
     * @var array
     */
    private $translators = [];

    public function init()
    {
        $translators = $this->getTranslators();
        foreach ($translators as $translator) {
            if (!isset($translator['type'])) {
                throw \Exception(__CLASS__.': \'type\' is required for translator');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function loadConfiguration($config = array())
    {
        if (isset($config['translators'])) {
            $this->setTranslators($config['translators']);
        }
        if (isset($config['language'])) {
            $this->setLanguage($config['language']);
        }
    }

    /**
     * @inheritdoc
     */
    public function translate($alias, array $params = array())
    {
        $result      = '';
        $translators = $this->getTranslators();
        foreach ($translators as $translator) {
            $trans = $translator->translate($alias, $params);
            if ($trans != '') {
                $result = $trans;
            }
        }
        return $result;
    }

    /**
     * Set translators
     *
     * @param array $translators
     * @return \pwf\components\i18n\Translator
     */
    public function setTranslators(array $translators)
    {
        $this->translators = $translators;
        return $this;
    }

    /**
     * Get translators
     *
     * @return array
     */
    public function getTranslators()
    {
        return $this->translators;
    }
}