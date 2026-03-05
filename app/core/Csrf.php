<?php

declare (strict_types = 1);

namespace App\Core;

class Csrf
{
    private string $sessionKey = 'csrf_token';
    private int $tokenLength   = 32;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Generate token
     */
    public function getToken(): string
    {
        if (empty($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = bin2hex(random_bytes($this->tokenLength));
        }

        return $_SESSION[$this->sessionKey];
    }

    /**
     * Validate token
     */
    public function validate(string $token): bool
    {
        if (empty($_SESSION[$this->sessionKey])) {
            return false;
        }

        return hash_equals($_SESSION[$this->sessionKey], $token);
    }

    /**
     * Remove token
     */
    public function destroy(): void
    {
        unset($_SESSION[$this->sessionKey]);
    }
}
