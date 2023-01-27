<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Managers\ManagerInterface;
use Appsas\Request;
use Appsas\Response;
use Appsas\Validator;

class BaseController
{
    public const TITLE = 'Mano puslapis';

    protected ManagerInterface $manager;

    public function __construct(protected HtmlRender $htmlRender, protected Response $response)
    {
    }

    protected function response(mixed $content): Response
    {
        $this->response->content = $content;
        return $this->response;
    }

    protected function render(string $template, mixed $content = null, array $params = []): Response
    {
        $this->response->content = $this->htmlRender->renderTemplate($template, $content);
        $this->response->params = $params;
        return $this->response;
    }

    protected function redirect(string $url, mixed $content): Response
    {
        $this->response->redirect($url, $content) ;
        return $this->response;
    }

    protected function generatePagination(int $total, Request $request): string
    {
        $currentPage = (int)$request->get('page');
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $limit = (int)$request->get('amount', 10);

        $amountOfPages = (int)ceil($total / $limit);

        $pageItems = '';
        for($i = 1; $amountOfPages >= $i; $i++) {
            if ($i === $currentPage) {
                $cssClass = 'active';
            } else {
                $cssClass = 'waves-effect';
            }
            $pageItems .= $this->htmlRender->renderTemplate(
                'layout/pagination/page_link',
                ['page' => $i, 'amount' => "&amount=$limit", 'cssClass' => $cssClass]
            );
        }
        $data = [
            'current_page' => $currentPage,
            'url' => $request->getUrl(),
            'prev' => '1',
            'amount' => $limit,
            'next' => $amountOfPages,
            'pages' => $pageItems
        ];
        return $this->htmlRender->renderTemplate('layout/pagination/list', $data);
    }

// *********************************************************************************************************************

    public function new(Request $request): Response
    {
        return $this->render(ltrim($request->getUrl(),'/'));
    }

    public function show(Request $request): Response
    {
        $person = $this->manager->getOne($request);

        return $this->render(ltrim($request->getUrl(),'/'), $person);
    }

    public function edit(Request $request): Response
    {
        $person = $this->manager->getOne($request);

        return $this->render(ltrim($request->getUrl(),'/'), $person);
    }

    public function store(Request $request): Response
    {
//        Validator::required($request->get('first_name'));
//        Validator::required($request->get('last_name'));
//        Validator::required($request->get('email'));
//        Validator::required($request->get('phone'));
//        Validator::required($request->get('address_id'));
//        Validator::required((int)$request->get('code'));
//        Validator::numeric((int)$request->get('code'));
//        Validator::asmensKodas((int)$request->get('code'));

        $this->manager->store($request);
        $url = '/'.explode('/', $request->getUrl())[1] . 's';

        return $this->redirect( $url, ['message' => "Record created successfully"]);
    }

    public function update(Request $request): Response
    {
//        Validator::required($request->get('first_name'));
//        Validator::required($request->get('last_name'));
//        Validator::required($request->get('code'));
//        Validator::numeric($request->get('code'));
//        Validator::asmensKodas($request->get('code'));

        $this->manager->update($request);

        $url = explode('/', $request->getUrl())[1];

        return $this->redirect('/'.$url.'/show?id=' . $request->get('id'), ['message' => "Record updated successfully"]);
    }

    public function delete(Request $request): Response
    {
        $id = (int)$request->get('id');

//        Validator::required($id);
//        Validator::numeric($id);
//        Validator::min($id, 1);

        $this->manager->delete($request);

        $url = explode('/', $request->getUrl())[1] . 's';
        return $this->redirect('/'.$url, ['message' => "Record deleted successfully"]);
    }
}