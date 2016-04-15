<?php

declare(strict_types = 1);

namespace pwf\components\i18n;

use pwf\basic\interfaces\Component;

class Translator extends abstraction\Translator implements \pwf\basic\interfaces\Component,
    interfaces\Translator
{
    /**
     * Translators
     *
     * @var array
     */
    private $translators = [];

    public function init(): Component
    {
        $translators = $this->getTranslators();
        foreach ($translators as $key => $translator) {
            if (!isset($translator['type'])) {
                throw new \Exception(__CLASS__ . ': \'type\' is required for translator');
            } else {
                $translators[$key] = (new Fabric())->getTranslator($translator['type'],
                    array_merge([
                        'language' => $this->getLanguage()
                    ], $translator));
            }
        }
        $this->setTranslators($translators);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function loadConfiguration(array $config = []): Component
    {
        if (isset($config['translators'])) {
            $this->setTranslators($config['translators']);
        }
        if (isset($config['language'])) {
            $this->setLanguage($config['language']);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function translate(string $alias, array $params = []): string
    {
        $result = '';
        $translators = $this->getTranslators();
        foreach ($translators as $translator) {
            if ($translator->getLanguage() === $this->getLanguage()) {
                $trans = $translator->translate($alias, $params);
                if ($trans != '') {
                    $result = $trans;
                    break;
                }
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
    public function setTranslators(array $translators): Translator
    {
        $this->translators = $translators;
        return $this;
    }

    /**
     * Get translators
     *
     * @return array
     */
    public function getTranslators(): array
    {
        return $this->translators;
    }
}