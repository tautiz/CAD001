<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Managers\UserManager;
use Appsas\Request;
use Appsas\Response;

class UserController extends BaseController implements ControllerInterface
{
    public const TITLE = 'Users';

    public function __construct(UserManager $userManager, HtmlRender $htmlRender, Response $response)
    {
        $this->manager = $userManager;
        parent::__construct($htmlRender, $response);
    }

    public function list(Request $request): Response
    {
        $users = $this->manager->getAll();
        $rez = $this->generateTable($users);

        return $this->render(
            'user/list',
            ['content' => $rez, 'pagination' => $this->generatePagination(1000, $request), 'title' => self::TITLE],
            ['title' => self::TITLE]
        );
    }

    /**
     * @param array $users
     * @return string
     */
    protected function generateTable(array $users): string
    {
        $rez = '<table class="highlight striped">
            <tr>
                <th>ID</th>
                <th>person_id</th>
                <th>password</th>
                <th>name</th>
                <th>state</th>
            </tr>';
        foreach ($users as $user) {
            $rez .= $this->htmlRender->renderTemplate('user/list/row', $user);
        }
        $rez .= '</table>';
        return $rez;
    }
}