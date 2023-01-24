<?php

namespace Appsas;

class HtmlRender extends AbstractRender
{
    public function setContent(mixed $content)
    {
        $fileContent = self::renderTemplate('layout/main', $content);

        $this->output->store($fileContent);
    }

    /**
     * @param string $template
     * @param mixed $content
     * @return string
     */
    public static function renderTemplate(string $template, mixed $content = null): string
    {
        // Iš kontrolerio funkcijos gautą atsakymą talpiname į main.html layout failą
        $fs = new FS("../src/html/$template.html");
        $fileContent = $fs->getFailoTurinys();
//        $title = $this->controller::TITLE;
//        $fileContent = str_replace("{{title}}", $title, $fileContent);
        if (is_array($content)) {
            foreach ($content as $key => $item) {
                $fileContent = str_replace("{{{$key}}}", $item, $fileContent);
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