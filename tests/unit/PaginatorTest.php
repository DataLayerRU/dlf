<?php

class PaginatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \pwf\components\activerecord\Paginator
     */
    public static $paginator;

    protected function setUp()
    {
        self::$paginator = \Codeception\Util\Stub::construct('\pwf\components\activerecord\Paginator');
    }

    protected function tearDown()
    {
        self::$paginator = null;
    }

    public function testMethods()
    {
        $condition = [
            'test' => 1
        ];

        $items1 = [
            new \stdClass()
        ];

        $items = [
            new \stdClass(),
            new \stdClass()
        ];

        \pwf\basic\Application::$instance = \Codeception\Util\Stub::construct('\pwf\basic\Application');

        $this->assertEquals('p',
            self::$paginator->setParamName('p')->getParamName());

        $datasource = \Codeception\Util\Stub::construct('\pwf\components\activerecord\abstraction\Model',
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
                'getAll' => function($condition, $limit = null, $offset = null) use ($items) {
                    $result = [];
                    for ($i = 0; $i < $limit; $i++) {
                        $result[] = new \stdClass();
                    }
                    return $result;
                },
                    'count' => function() {
                    return 2;
                }
            ]);

            $this->assertEquals($condition,
                self::$paginator->setCondition($condition)->getCondition());

            $this->assertEquals($datasource,
                self::$paginator->setDataSource($datasource)->getDataSource());

            $this->assertEquals([
                new \stdClass()
                ], self::$paginator->setLimit(1)->getData());

            $this->assertEquals($items1, self::$paginator->setPage(2)->getData());
            $this->assertEquals([],
                self::$paginator->setLimit(0)->setPage(0)->getData());
        }
    }