<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Managers\AddressManager;
use Appsas\Request;
use Appsas\Response;

class AddressController extends BaseController implements ControllerInterface
{
    public const TITLE = 'Adresai';

    public function __construct(AddressManager $manager, Response $response, HtmlRender $htmlRender)
    {
        $this->manager = $manager;
        parent::__construct($htmlRender, $response);
    }

    public function list(Request $request): Response
    {
        return $this->render(
            'address/list',
            ['title' => self::TITLE],
            ['title' => self::TITLE]
        );
    }
}