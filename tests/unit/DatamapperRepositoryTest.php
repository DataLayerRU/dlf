<?php

class DatamapperRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \pwf\components\datamapper\abstraction\Repository
     */
    public static $dmstub;

    protected function setUp()
    {
        self::$dmstub = \Codeception\Util\Stub::construct('\pwf\components\datamapper\abstraction\Repository',
                [],
                [
                'save' => function(\pwf\components\datamapper\Model $model) {
                    return true;
                },
                'delete' => function(\pwf\components\datamapper\Model $model) {
                    return true;
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
            self::$dmstub = null;
        }

        public function testConnection()
        {
            $connection = new \stdClass();
            $this->assertEquals($connection,
                self::$dmstub->setConnection($connection)->getConnection());
        }
    }