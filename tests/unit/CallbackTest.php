<?php

class CallbackClass
{

    use \pwf\components\eventhandler\traits\CallbackTrait;
}

class EventClass
{

    use \pwf\components\eventhandler\traits\EventTrait;
}

class CallbackTest extends \PHPUnit_Framework_TestCase
{

    public function testMethods()
    {
        $callbackClass = \Codeception\Util\Stub::make('CallbackClass');

        $callable = [
            'CallbackClass',
            'method'
        ];

        $callback = function() {
            return 'test';
        };

        $this->assertEquals($callback,
            $callbackClass->setCallbacks([$callback])->getCallbacks()[0]);

//        $this->assertEquals([
//            new CallbackClass(),
//            'method'
//            ], $callbackClass->prepareCallback(implode('::', $callable)));

        try {
            $callbackClass->prepareCallback(['test']);
            $this->fail();
        } catch (Exception $ex) {
            $this->assertTrue(true);
        }
    }

    public function testEvent()
    {
        $eventStub = \Codeception\Util\Stub::make('EventClass');

        $eventStub->on('testEvent',
            function() {
            throw new Exception('test');
        });

        try {
            $eventStub->trigger('testEvent');
            $this->fail();
        } catch (Exception $ex) {
            $this->assertTrue(true);
        }

        \Codeception\Util\Stub::update($eventStub,
            [
            'testEvent' => function() {
                return true;
            }
        ]);

        try {
            $eventStub->clear()->on('testEvent',
                function() {
                return true;
            })->trigger('testEvent');
            $this->assertTrue(true);
        } catch (Exception $ex) {
            $this->fail($ex->getMessage()."\n".$ex->getTraceAsString());
        }
    }

    public function testDecorator()
    {
        $obj      = \Codeception\Util\Stub::makeEmpty('\pwf\basic\controller\WebController',
                [
                'getView' => function() {
                    return true;
                },
                'setView' => function(\pwf\basic\interfaces\View $view) {
                    return true;
                }
        ]);
        $decorated = new \pwf\components\eventhandler\ObjectDecorator();
        $this->assertEquals($obj, $decorated->setObject($obj)->getObject());
        $this->assertTrue($decorated->getView());
    }
}