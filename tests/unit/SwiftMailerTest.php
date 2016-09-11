<?php

class SwiftMailerTest extends \PHPUnit_Framework_TestCase
{
    private $component;

    protected function setUp()
    {
        $this->component = Codeception\Util\Stub::construct('\pwf\components\swiftmailer\SwiftMailer',
                [], [
                'send' => function() {

                }
        ]);
        $this->component->loadConfiguration([])->init();
    }

    protected function tearDown()
    {
        $this->component = null;
    }

    public function testIt()
    {
        $this->component
            ->addMail($this->component->createMail()->addTo('test@test.ru')->setBody('Test'))
            ->send();
    }

    public function testTransport()
    {
        try {
            $this->component->loadConfiguration([
                'transport' => 'smtp',
                'username' => 'test',
                'password' => 'test'
            ])->init();
            $this->component->loadConfiguration([
                'transport' => 'sendmail'
            ])->init()->getTransport();
        } catch (Exception $ex) {
            $this->fail($ex->getMessage());
        }
    }
}