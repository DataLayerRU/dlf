<?php

namespace pwf\basic\db;

abstract class DBModel extends \pwf\components\activerecord\Model
{
    abstract public function getTable();

    protected function getQueryBuilder()
    {
        
    }


    public function count($condition)
    {
        
    }

    public function delete()
    {

    }

    public function getAll($condition, $limit = null, $offset = null)
    {
        
    }

    public function getId()
    {

    }

    public function getOne($condition)
    {
        
    }

    public function save()
    {

    }
}