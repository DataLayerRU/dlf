<?php

use pwf\components\i18n\Translator;
use pwf\components\i18n\interfaces\Translator as trans;

class i18nTest extends \PHPUnit_Framework_TestCase
{
    private $translator;

    protected function setUp()
    {
        $this->translator = new Translator();
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

    public function testIt()
    {
        $translatedWord = 'Тест';

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

        $this->assertEquals($translatedWord, $translation);
    }
}