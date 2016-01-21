<?php

namespace pwf\basic\interfaces;

interface Model
{

    /**
     * Get one record by primary key
     *
     * @param integer $primaryKeyValue
     */
    public function getOne($primaryKeyValue);

    /**
     * Get all rows
     *
     * @param \pwf\components\dbconnection\interfaces\Connection $db
     * @return \project\models\UserModel[]
     */
    public static function getAll(\pwf\components\dbconnection\interfaces\Connection $db);

    /**
     * Save model
     *
     * @return integer
     */
    public function save();

    /**
     * Validate input
     * 
     * @param array $attributes
     */
    public function validate($attributes = []);
}