<?php

namespace Appsas\Controllers;

use Appsas\Authenticator;
use Appsas\Exceptions\UnauthenticatedException;
use Appsas\HtmlRender;

class AdminController extends BaseController
{
    private Authenticator $authenticator;
    // BAD PRACTICE: DI metu priskirti numatytasias (Default) reiksmes
    public function __construct(Authenticator $authenticator = null)
    {
        $this->authenticator = $authenticator ?? new Authenticator();
    }

    /**
     * @throws UnauthenticatedException
     */
    public function index()
    {
        if (!$this->authenticator->isLoggedIn()) {
            throw new UnauthenticatedException();
        }

        return 'ADMIN puslapis';
//        $render = new HtmlRender($output);
//        $render->render();
    }

    /**
     * @throws UnauthenticatedException
     */
    public function login()
    {
        $userName = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if(!empty($userName) && !empty($password)) {
            $this->authenticator->login($userName, $password);
            header('Location: /admin');
        }
    }


    public function logout()
    {
        $this->authenticator->logout();
        return '';
    }
}