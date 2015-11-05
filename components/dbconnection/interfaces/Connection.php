<?php

namespace dlf\components\dbconnection\interfaces;

interface Connection
{

    public function connect($params = []);

    public function disconnect();

    public function query($query, $params = []);

    public function exec($query, $params = []);
}