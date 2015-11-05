<?php

namespace dlf\basic\interfaces;

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
     * @param \dlf\components\dbconnection\interfaces\Connection $db
     * @return \project\models\UserModel[]
     */
    public static function getAll(\dlf\components\dbconnection\interfaces\Connection $db);

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