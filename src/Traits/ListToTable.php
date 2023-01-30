<?php

namespace Appsas\Traits;

use Appsas\Models\ModelInterface;
use Appsas\Request;
use Appsas\Response;
use ReflectionException;

Trait ListToTable
{
    public function list(Request $request): Response
    {
        $models = $this->manager->getFiltered($request);
        $total = $this->manager->getTotal();
        $modelName = strtolower($this->manager->getModelName());
        $template = "$modelName/list/row";

        $rez = $this->generateTable($template, $models);

        return $this->render(
            "$modelName/list",
            ['content' => $rez, 'pagination' => $this->generatePagination($total, $request), 'title' => self::TITLE],
            ['title' => self::TITLE]
        );
    }

    /**
     * @param string $template
     * @param array $models
     * @return string
     * @throws ReflectionException
     */
    protected function generateTable(string $template, array $models): string
    {
        $listOfTableColumns = $this->manager->getListOfTableColumns();

        $rez = '<table class="highlight striped"><tr>';
        foreach ($listOfTableColumns as $columnName) {
            $rez .= '<th>' . $columnName . '</th>';
        }
        $rez .= '</tr>';

        /** @var ModelInterface $model */
        foreach ($models as $model) {
            $rez .= $this->htmlRender->renderTemplate($template, $model->toArray());
        }
        $rez .= '</table>';
        return $rez;
    }
}