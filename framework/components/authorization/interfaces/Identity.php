<?php

namespace pwf\components\authorization\interfaces;

interface Identity
{

    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get authorization token
     *
     * @return string
     */
    public function getAuthToken();

    /**
     * Get user by token
     *
     * @param string $token
     * @return Identity
     */
    public function getByAuthToken($token);
}