<?php

namespace pwf\components\i18n\abstraction;

abstract class FileTranslator extends Translator implements \pwf\components\i18n\interfaces\FileTranslator
{
    /**
     * Path to lang dir
     *
     * @var string
     */
    private $dir;

    /**
     * Set dir
     *
     * @param string $dir
     * @return \pwf\components\i18n\abstraction\FileTranslator
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
        return $this;
    }

    /**
     * Get path to directory
     *
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }
}