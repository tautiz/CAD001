<?php

namespace Appsas\Controllers;

use Appsas\Authenticator;
use Appsas\Exceptions\UnauthenticatedException;
use Appsas\HtmlRender;
use Appsas\Request;
use Appsas\Response;

class AdminController extends BaseController
{
    private Authenticator $authenticator;
    // BAD PRACTICE: DI metu priskirti numatytasias (Default) reiksmes
    public function __construct(Authenticator $authenticator = null)
    {
        $this->authenticator = $authenticator ?? new Authenticator();
        parent::__construct();
    }

    /**
     * @throws UnauthenticatedException
     */
    public function index(): Response
    {
        if (!$this->authenticator->isLoggedIn()) {
            throw new UnauthenticatedException();
        }

        return $this->response('ADMIN puslapis');
    }

    /**
     * @throws UnauthenticatedException
     */
    public function login(Request $request): Response
    {
        $userName = $request->get('username');
        $password = $request->get('password');

        if(!empty($userName) && !empty($password)) {
            $this->authenticator->login($userName, $password);
            return $this->redirect('/admin', 'Sveikiname prisijungus');
        }
    }


    public function logout(): Response
    {
        $this->authenticator->logout();
        $this->redirect('/', 'Sveikiname atsijungus');
    }
}