<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Managers\AddressManager;
use Appsas\Response;
use Appsas\Traits\ListToTable;

class AddressController extends BaseController implements ControllerInterface
{
    use ListToTable;
    public const TITLE = 'Adresai';

    public function __construct(AddressManager $manager, Response $response, HtmlRender $htmlRender)
    {
        $this->manager = $manager;
        parent::__construct($htmlRender, $response);
    }
}