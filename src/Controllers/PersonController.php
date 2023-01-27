<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Managers\PersonsManager;
use Appsas\Request;
use Appsas\Response;

class PersonController extends BaseController implements ControllerInterface
{
    public const TITLE = 'Asmenys';

    public function __construct(PersonsManager $manager, Response $response, HtmlRender $htmlRender)
    {
        $this->manager = $manager;
        parent::__construct($htmlRender, $response);
    }

    public function list(Request $request): Response
    {
        $persons = $this->manager->getFiltered($request);
        $total = $this->manager->getTotal();
        $rez = $this->generatePersonsTable($persons);

        return $this->render(
            'person/list',
            ['content' => $rez, 'pagination' => $this->generatePagination($total, $request), 'title' => self::TITLE],
            ['title' => self::TITLE]
        );
    }

    /**
     * @param array $asmenys
     * @return string
     */
    protected function generatePersonsTable(array $asmenys): string
    {
        $rez = '<table class="highlight striped">
            <tr>
                <th>ID</th>
                <th>Vardas</th>
                <th>Pavarde</th>
                <th>Emailas</th>
                <th>Asmens kodas</th>
                <th><a href="/persons?orderby=phone">TEl</a></th>
                <th>Addr.ID</th>
                <th>Veiksmai</th>
            </tr>';
        foreach ($asmenys as $asmuo) {
            $rez .= $this->htmlRender->renderTemplate('person/person_row', $asmuo);
        }
        $rez .= '</table>';
        return $rez;
    }
}