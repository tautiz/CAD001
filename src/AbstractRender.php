<?php

namespace Appsas;

abstract class AbstractRender
{
    protected $output;

    public function __construct(Output $output)
    {
        $this->output = $output;
    }

    public function render()
    {
        $this->output->store($this->getContent());
    }

    abstract protected function getContent();
}