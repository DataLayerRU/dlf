<?php

class SubjectClass
{

    use \pwf\components\observer\traits\Subject;
}

class ObserverClass implements \pwf\components\observer\interfaces\Observer
{

    public function update(\pwf\components\observer\interfaces\Subject $subject)
    {
        throw new Exception('Test');
    }
}

class ObserverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SubjectClass
     */
    public static $stubSubject;

    /**
     * @var \pwf\components\observer\interfaces\Observer
     */
    public static $stubObserver;

    protected function setUp()
    {

        self::$stubSubject  = \Codeception\Util\Stub::make('SubjectClass');
        self::$stubObserver = \Codeception\Util\Stub::makeEmpty('\pwf\components\observer\interfaces\Observer');
    }

    protected function tearDown()
    {
        self::$stubSubject  = null;
        self::$stubObserver = null;
    }

    public function testObserver()
    {
        try {
            self::$stubSubject
                ->attach(self::$stubObserver)
                ->notify();
            $this->fail();
        } catch (Exception $ex) {
            $this->assertTrue(true);
        }

        try {
            self::$stubSubject
                ->detach(self::$stubObserver)
                ->notify();
            $this->assertTrue(true);
        } catch (Exception $ex) {
            $this->fail($ex->getMessage());
        }
    }
}