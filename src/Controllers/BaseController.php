<?php

namespace Appsas\Controllers;

use Appsas\HtmlRender;
use Appsas\Request;
use Appsas\Response;

class BaseController
{
    public const TITLE = 'Mano puslapis';

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
            'url' => '/persons',
            'prev' => '1',
            'amount' => $limit,
            'next' => $amountOfPages,
            'pages' => $pageItems
        ];
        return $this->htmlRender->renderTemplate('layout/pagination/list', $data);
    }

}