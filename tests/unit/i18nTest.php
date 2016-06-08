<?php

use pwf\components\i18n\interfaces\Translator as trans;

class i18nTest extends \PHPUnit_Framework_TestCase
{
    private $translator;

    protected function setUp()
    {
        $this->translator = Codeception\Util\Stub::construct('\pwf\components\i18n\Translator');
    }

    protected function tearDown()
    {
        $this->translator = null;
    }

    public function testBadInit()
    {
        $this->translator->loadConfiguration([
            'translators' => [
                [
                    'param' => 1
                ]
            ],
            'language' => 'ru'
        ]);

        try {
            $this->translator->init();
            $this->fail();
        } catch (Exception $ex) {
            
        }
    }

    public function testExceptions()
    {
        $translatedWord = 'Тест';

        try {
            $translation = $this->translator->loadConfiguration([
                    'translators' => [
                        [
                            'type' => trans::TRANSLATOR_ARRAY,
                            'map' => [
                                'ru' => [
                                    'test' => $translatedWord
                                ]
                            ]
                        ],
                        [
                            'type' => trans::TRANSLATOR_FILE,
                            'dir' => 'tests/_data/'
                        ]
                    ],
                    'language' => 'ru'
                ])->init()->translate('test');
            $this->fail('Need exception');
        } catch (Exception $ex) {

        }

        try {
            $translation = $this->translator->loadConfiguration([
                    'translators' => [
                        [
                            'type' => trans::TRANSLATOR_FILE,
                            'language' => 'ru'
                        ]
                    ],
                    'language' => 'ru'
                ])->init()->translate('test');
            $this->fail('Need exception');
        } catch (Exception $ex) {

        }

        try {
            $translation = $this->translator->loadConfiguration([
                    'translators' => [
                        [
                            'type' => trans::TRANSLATOR_ARRAY,
                            'language' => 'ru'
                        ]
                    ],
                    'language' => 'ru'
                ])->init()->translate('test');
            $this->fail('Need exception');
        } catch (Exception $ex) {
            
        }

        try {
            $translation = $this->translator->loadConfiguration([
                    'translators' => [
                        [
                            'type' => trans::TRANSLATOR_DB,
                            'language' => 'ru'
                        ]
                    ],
                    'language' => 'ru'
                ])->init()->translate('test');
            $this->fail('Need exception');
        } catch (Exception $ex) {

        }

        try {
            $translation = $this->translator->loadConfiguration([
                    'translators' => [
                        [
                            'type' => trans::TRANSLATOR_DB,
                            'language' => 'ru',
                            'aliasFieldName' => 'field1'
                        ]
                    ],
                    'language' => 'ru'
                ])->init()->translate('test');
            $this->fail('Need exception');
        } catch (Exception $ex) {

        }

        try {
            $translation = $this->translator->loadConfiguration([
                    'translators' => [
                        [
                            'type' => trans::TRANSLATOR_DB,
                            'language' => 'ru',
                            'aliasFieldName' => 'field1',
                            'languageFieldName' => 'field1'
                        ]
                    ],
                    'language' => 'ru'
                ])->init()->translate('test');
            $this->fail('Need exception');
        } catch (Exception $ex) {

        }

        try {
            $translation = $this->translator->loadConfiguration([
                    'translators' => [
                        [
                            'type' => trans::TRANSLATOR_DB,
                            'language' => 'ru',
                            'aliasFieldName' => 'field1',
                            'languageFieldName' => 'field2',
                            'resultFieldName' => 'field3'
                        ]
                    ],
                    'language' => 'ru'
                ])->init()->translate('test');
            $this->fail('Need exception');
        } catch (Exception $ex) {

        }

        try {
            $translation = $this->translator->loadConfiguration([
                    'translators' => [
                        [
                            'type' => trans::TRANSLATOR_DB,
                            'language' => 'ru',
                            'aliasFieldName' => 'field1',
                            'languageFieldName' => 'field2',
                            'resultFieldName' => 'field3',
                            'table' => 'table_name'
                        ]
                    ],
                    'language' => 'ru'
                ])->init()->translate('test');
            $this->fail('Need exception');
        } catch (Exception $ex) {

        }
    }

    public function testIt()
    {
        $translatedWord = 'Тест ok';
        \pwf\basic\db\QueryBuilder::setDriver(\pwf\basic\db\QueryBuilder::DRIVER_MYSQL);
        $connection     = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'query' => function($query, $params = []) {
                return new PDOStatement();
            }
        ]);

        $translation = $this->translator->loadConfiguration([
                'translators' => [
                    [
                        'type' => trans::TRANSLATOR_ARRAY,
                        'language' => 'ru',
                        'map' => [
                            'ru' => [
                                'test' => 'Тест {placeholder}'
                            ]
                        ]
                    ],
                    [
                        'type' => trans::TRANSLATOR_DB,
                        'language' => 'ru',
                        'aliasFieldName' => 'field1',
                        'languageFieldName' => 'field2',
                        'resultFieldName' => 'field3',
                        'table' => 'table_name',
                        'connection' => $connection
                    ]
                ],
                'language' => 'ru'
            ])->init()->translate('test', ['placeholder' => 'ok']);

        $this->assertEquals($translatedWord, $translation);

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection',
                [],
                [
                'query' => function($query, $params = []) {
                return Codeception\Util\Stub::constructEmpty('\PDOStatement',
                        [],
                        [
                        'fetchColumn' => function($field) {
                            return 'Тест {placeholder}';
                        }
                ]);
            }
        ]);
        $translation = $this->translator->loadConfiguration([
                'translators' => [
                    [
                        'type' => trans::TRANSLATOR_DB,
                        'language' => 'ru',
                        'aliasFieldName' => 'field1',
                        'languageFieldName' => 'field2',
                        'resultFieldName' => 'field3',
                        'table' => 'table_name',
                        'connection' => $connection
                    ]
                ],
                'language' => 'ru'
            ])->init()->translate('test', ['placeholder' => 'ok']);

        $this->assertEquals($translatedWord, $translation);

        $translation = $this->translator->loadConfiguration([
                'translators' => [
                    [
                        'type' => trans::TRANSLATOR_FILE,
                        'language' => 'ru',
                        'dir' => 'tests/_data/'
                    ]
                ],
                'language' => 'ru'
            ])->init()->translate('test', ['placeholder' => 'ok']);

        $this->assertEquals($translatedWord, $translation);
    }
}