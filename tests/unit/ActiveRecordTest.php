<?php

class ActiveRecordTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \pwf\components\activerecord\Model
     */
    public static $arstub;

    protected function setUp()
    {
        self::$arstub = \Codeception\Util\Stub::construct('\pwf\components\activerecord\Model',
                [
                'connection' => new \stdClass()
                ],
                [
                'save' => function() {
                    return true;
                },
                'delete' => function() {
                    return true;
                },
                'getId' => function() {
                    return 1;
                },
                'getOne' => function($condition) {
                    return new \stdClass();
                },
                'getAll' => function($condition, $limit = null, $offset = null) {
                    return [
                        new \stdClass(),
                        new \stdClass()
                    ];
                },
                    'count' => function() {
                    return 2;
                }
            ]);
        }

        protected function tearDown()
        {
            self::$arstub = null;
        }

        public function testAttributes()
        {
            $this->assertEquals('testvalue',
                self::$arstub->setAttribute('test', 'testvalue')->getAttribute('test'));

            $this->assertArrayHasKey('test', self::$arstub->getAttributes());

            $this->assertNotEmpty(self::$arstub->test);

            $this->assertEmpty(self::$arstub->notExistTest);

            self::$arstub->test = 'newTestValue';

            $this->assertEquals('newTestValue', self::$arstub->test);

            unset(self::$arstub->test);

            $this->assertFalse(isset(self::$arstub->test));

            $this->assertInstanceOf('\stdClass', self::$arstub->getConnection());
        }

        public function testErrors()
        {
            $this->assertEquals('Error',
                self::$arstub->addError('test', 'Error')->getError('test'));
            $this->assertTrue(self::$arstub->isErrorExists('test'));
            $this->assertTrue(self::$arstub->hasErrors());
        }
    }