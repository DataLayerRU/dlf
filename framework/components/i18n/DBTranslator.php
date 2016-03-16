<?php

namespace pwf\components\i18n;

class ArrayTranslator extends \pwf\components\i18n\abstraction\DBTranslator
{

    use traits\ParamReplace;

    /**
     * Translate
     *
     * @param string $alias
     * @param array $params
     * @return string
     */
    public function translate($alias, array $params = array())
    {
        $result = '';
        $query  = $this->getQueryBuilder()
            ->select([$this->getResultFieldName()])
            ->where([
                $this->getLanguageFieldName() => $this->getLanguage(),
                $this->getAliasFieldName() => $alias
            ])
            ->table($this->getTableName())
            ->generate();
        $res    = $this->getConnection()->query($query,
            $this->getQueryBuilder()->getParams());

        if ($res !== false) {
            $result = $this->prepareValue($res->fetchColumn($this->getResultFieldName()));
        }
        return $result;
    }
}