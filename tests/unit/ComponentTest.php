<?php

class ComponentTest extends \PHPUnit_Framework_TestCase
{
    public static $stubComponent;

    protected function setUp()
    {
        self::$stubComponent = Codeception\Util\Stub::make('\pwf\basic\Component',
                [
                'init' => function() {
                    return true;
                }
        ]);
    }

    protected function tearDown()
    {
        self::$stubComponent = null;
    }

    /**
     * @covers \pwf\basic\Component::loadConfiguration
     * @covers \pwf\basic\Component::isForceInitialization
     * @covers \pwf\basic\Component::init
     */
    public function testBaseComponent()
    {
        $this->assertTrue(self::$stubComponent->loadConfiguration([
                'force' => 1
            ])->isForceInitialization());
    }
}