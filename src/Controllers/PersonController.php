<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Managers\PersonsManager;
use Appsas\Response;
use Appsas\Traits\ListToTable;

class PersonController extends BaseController implements ControllerInterface
{
    use ListToTable;
    public const TITLE = 'Asmenys';

    public function __construct(PersonsManager $manager, Response $response, HtmlRender $htmlRender)
    {
        $this->manager = $manager;
        parent::__construct($htmlRender, $response);
    }
}