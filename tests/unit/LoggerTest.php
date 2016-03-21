<?php

class LoggerTest extends \PHPUnit_Framework_TestCase
{

    public function testException()
    {
        $logger = Codeception\Util\Stub::construct('\pwf\components\monologadapter\MonologLogger');
        $logger->loadConfiguration([
            'handlers' => [
                [
                    'testException'
                ]
            ]
        ]);

        try {
            $logger->init();
            $this->fail();
        } catch (Exception $ex) {

        }
    }

    public function testIt()
    {
        $logger = Codeception\Util\Stub::construct('\pwf\components\monologadapter\MonologLogger');
        $logger->loadConfiguration([
            'handlers' => [
                [
                    'class' => '\Monolog\Handler\StreamHandler',
                    'params' => [
                        '_output/logs/test.log',
                        Monolog\Logger::WARNING
                    ]
                ]
            ]
        ])->init();
    }
}