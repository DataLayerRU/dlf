<?php

declare(strict_types = 1);

namespace pwf\components\i18n;

class DBTranslator extends \pwf\components\i18n\abstraction\DBTranslator
{

    use traits\ParamReplace;

    /**
     * Translate
     *
     * @param string $alias
     * @param array $params
     * @return string
     */
    public function translate(string $alias, array $params = []): string
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
            $result = $this->prepareValue($res->fetchColumn($this->getResultFieldName()), $params);
        }
        return $result;
    }
}