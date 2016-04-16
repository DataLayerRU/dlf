<?php

class PaginatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \pwf\basic\db\Paginator
     */
    public static $paginator;

    protected function setUp()
    {
        self::$paginator = \Codeception\Util\Stub::construct('\pwf\basic\db\Paginator');
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

        $conn = \Codeception\Util\Stub::make('\pwf\components\dbconnection\abstraction\Connection');

        $this->assertEquals('p',
            self::$paginator->setParamName('p')->getParamName());

        $datasource = \Codeception\Util\Stub::make('pwf\basic\db\DBModel',
            [
                'connection' => $conn
            ]);

        $this->assertEquals($datasource,
            self::$paginator->setDataSource($datasource)->getDataSource());

        $datasource1 = \Codeception\Util\Stub::construct('pwf\basic\db\DBModel',
            [
                'connection' => $conn
            ],
            [
                'save' => function () {
                    return true;
                },
                'delete' => function () {
                    return true;
                },
                'getId' => function () {
                    return 1;
                },
                'getOne' => function ($condition) {
                    return new \stdClass();
                },
                'getAll' => function () use ($items, $datasource) {
                    $result = [];
                    $result[] = new \stdClass();
                    return $result;
                },
                'count' => function () {
                    return 2;
                }
            ]);

        self::$paginator->setDataSource($datasource1);

        $this->assertEquals([
            new \stdClass()
        ], self::$paginator->setLimit(1)->getData());

        $datasource1 = \Codeception\Util\Stub::construct('pwf\basic\db\DBModel',
            [
                'connection' => $conn
            ],
            [
                'save' => function () {
                    return true;
                },
                'delete' => function () {
                    return true;
                },
                'getId' => function () {
                    return 1;
                },
                'getOne' => function ($condition) {
                    return new \stdClass();
                },
                'getAll' => function () use ($items1) {
                    return $items1;
                },
                'count' => function () {
                    return 2;
                }
            ]);

        self::$paginator->setDataSource($datasource1);

        $this->assertEquals($items1, self::$paginator->setPage(2)->getData());

        $datasource1 = \Codeception\Util\Stub::construct('pwf\basic\db\DBModel',
            [
                'connection' => $conn
            ],
            [
                'save' => function () {
                    return true;
                },
                'delete' => function () {
                    return true;
                },
                'getId' => function () {
                    return 1;
                },
                'getOne' => function ($condition) {
                    return new \stdClass();
                },
                'getAll' => function () {
                    return [];
                },
                'count' => function () {
                    return 2;
                }
            ]);

        self::$paginator->setDataSource($datasource1);

        $this->assertEquals([],
            self::$paginator->setLimit(0)->setPage(0)->getData());
    }
}