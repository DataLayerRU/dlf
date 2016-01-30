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
     * @return mixed
     */
    public function getAuthToken();

    /**
     * Get user by token
     *
     * @param mixed $token
     * @return Identity
     */
    public function getByAuthToken($token);
}