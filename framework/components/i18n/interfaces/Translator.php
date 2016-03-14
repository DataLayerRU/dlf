<?php

namespace pwf\components\i18n\interfaces;

interface Translator
{

    /**
     * Get translation
     *
     * @param string $alias
     * @param array $params
     * @return Translator
     */
    public function translate($alias, array $params = array());

    /**
     * Set current language
     *
     * @param string $lang
     * @return Translator
     */
    public function setLanguage($lang);
}