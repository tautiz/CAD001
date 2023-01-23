<?php

namespace Appsas;

class HtmlRender extends AbstractRender
{
    public function setContent(mixed $content)
    {
        // Iš kontrolerio funkcijos gautą atsakymą talpiname į main.html layout failą
        $fs = new FS('../src/html/layout/main.html');
        $fileContent = $fs->getFailoTurinys();
//        $title = $this->controller::TITLE;
//        $fileContent = str_replace("{{title}}", $title, $fileContent);
        if (is_array($content)) {
            foreach ($content as $key => $item) {
                $fileContent = str_replace("{{{$key}}}", $item, $fileContent);
            }
        } else {
            $fileContent = str_replace("{{content}}", $content, $fileContent);
        }

        // Išvalomi Templeituose likę {{}} tagai
        preg_match_all('/{{(.*?)}}/', $fileContent, $matches);
        foreach ($matches[0] as $key) {
            $fileContent = str_replace($key, '', $fileContent);
        }

        $this->output->store($fileContent);
    }
}