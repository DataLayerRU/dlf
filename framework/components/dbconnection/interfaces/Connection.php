<?php

namespace pwf\components\dbconnection\interfaces;

interface Connection
{

    public function connect(array $params = []);

    public function disconnect();

    public function query($query, array $params = []);

    public function exec($query, array $params = []);
}