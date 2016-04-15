<?php

declare(strict_types = 1);

namespace pwf\components\i18n\interfaces;

interface Translator
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
     * Get translation
     *
     * @param string $alias
     * @param array $params
     * @return string
     */
    public function translate(string $alias, array $params = []): string;

    /**
     * Set current language
     *
     * @param string $lang
     * @return Translator
     */
    public function setLanguage(string $lang): Translator;
}