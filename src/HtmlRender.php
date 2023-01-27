<?php

namespace Appsas;

use Appsas\FS;
use Appsas\Output;

class HtmlRender extends AbstractRender
{
    public function __construct(Output $output, protected FS $fs)
    {
        parent::__construct($output);
    }

    public function setContent(mixed $content)
    {
        $fileContent = $this->renderTemplate('layout/main', $content);

        $this->output->store($fileContent);
    }

    /**
     * @param string $template
     * @param mixed $content
     * @return string
     */
    public function renderTemplate(string $template, mixed $content = null): string
    {
        // Iš kontrolerio funkcijos gautą atsakymą talpiname į main.html layout failą
        $this->fs->setFailoPavadinimas("../src/html/$template.html");
        $fileContent = $this->fs->getFailoTurinys();
        if (is_array($content)) {
            foreach ($content as $key => $item) {
                $fileContent = str_replace("{{{$key}}}", $item ?? '', $fileContent);
            }
        } elseif (is_string($content)) {
            $fileContent = str_replace("{{content}}", $content, $fileContent);
        }

        // Išvalomi Templeituose likę {{}} tagai
        preg_match_all('/{{(.*?)}}/', $fileContent, $matches);
        foreach ($matches[0] as $key) {
            $fileContent = str_replace($key, '', $fileContent);
        }

        return $fileContent;
    }
}