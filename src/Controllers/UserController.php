<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Managers\UserManager;
use Appsas\Response;
use Appsas\Traits\ListToTable;

class UserController extends BaseController implements ControllerInterface
{
    use ListToTable;
    public const TITLE = 'Users';

    public function __construct(UserManager $userManager, HtmlRender $htmlRender, Response $response)
    {
        $this->manager = $userManager;
        parent::__construct($htmlRender, $response);
    }
}