<?php

declare(strict_types = 1);

namespace pwf\components\dbconnection\interfaces;

interface Connection
{

    /**
     * Connect
     *
     * @param array $params
     * @return Connection
     */
    public function connect(array $params = []): Connection;

    /**
     * Disconnect
     *
     * @return Connection
     */
    public function disconnect(): Connection;

    /**
     * Select query
     *
     * @param $query
     * @param array $params
     * @return \PDOStatement
     */
    public function query(string $query, array $params = []): \PDOStatement;

    /**
     * Execute query
     *
     * @param $query
     * @param array $params
     * @return \PDOStatement
     */
    public function exec(string $query, array $params = []): \PDOStatement;
}