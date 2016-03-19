<?php

class DBModelTest extends \PHPUnit_Framework_TestCase {

    private static $model;

    protected function setUp() {
        \pwf\basic\db\QueryBuilder::setDriver(\pwf\basic\db\QueryBuilder::DRIVER_MYSQL);
    }

    protected function tearDown() {
        self::$model = null;
    }

    public function testCount() {
        $countQuery = 'SELECT COUNT(id) AS CNT FROM test_table WHERE field1=:field1 AND field2=:field2';

        $connection = Codeception\Util\Stub::construct('\pwf\components\dbconnection\PDOConnection', [], [
                    'query' => function($query, $params = []) use($countQuery) {

                $this->assertEquals($query, $countQuery);

                return new PDOStatement();
            },
                    'exec' => function($query, $params = [])use($countQuery) {

                $this->assertEquals($query, $countQuery);

                return new PDOStatement();
            }
        ]);

        self::$model = Codeception\Util\Stub::construct('\pwf\basic\db\DBModel', [
                    'connection' => $connection
                        ], [
                    'getId' => function() {
                        return 1;
                    }
        ]);

        self::$model
                ->table('test_table')
                ->setPK('id')
                ->where([
                    'field1' => 1,
                    'field2' => 2
                ])->count([]);
    }

}
