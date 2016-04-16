<?php

declare(strict_types = 1);

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
    public function getAuthToken(): string;

    /**
     * Get user by token
     *
     * @param string $token
     * @return Identity
     */
    public function getByAuthToken(string $token): Identity;
}