<?php

namespace Appsas;

use Appsas\Exceptions\UnauthenticatedException;

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
     * @throws UnauthenticatedException
     */
    public function login(string $checkUser, string $checkPass): bool
    {
        $loginsMas = [
            'admin' => 'slapta',
            'tautiz' => 'pass',
        ];

        foreach ($loginsMas as $username => $pass) {
            if ($checkUser === $username && $checkPass === $pass) {
                $_SESSION['logged'] = true;
                $_SESSION['username'] = $checkUser ?? $_SESSION['username'];
                return true;
            }
        }

        throw new UnauthenticatedException();
    }
    //TODO: sukurti logout Metoda --------------------------------------------------------------------------------
    // Vieta kur atloginam vartotoja
//    if ($_GET['logout'] ?? false) {
//        $_SESSION['logged'] = false;
//        $_SESSION['username'] = null;
//    }
    //--------------------------------------------------------------------------------
}