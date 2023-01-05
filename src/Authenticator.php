<?php

namespace Appsas;

class Authenticator
{
    public function authenticate(string|null $userName, string|null $password): bool
    {
        return $this->isLoggedIn() || !empty($userName) && !empty($password) && $this->login($userName, $password);
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['logged']) && $_SESSION['logged'] === true;
    }

    /**
     * @param string $checkUser
     * @param string $checkPass
     * @return bool
     */
    public function login(string $checkUser, string $checkPass): bool
    {
        $loginsMas = [
            'admin' => 'slapta',
            'tautiz' => 'pass',
        ];

        foreach ($loginsMas as $username => $pass) {
            if ($checkUser === $username && $checkPass === $pass) {
                return true;
            }
        }

        return false;
    }
}