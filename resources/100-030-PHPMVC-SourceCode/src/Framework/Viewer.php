<?php

namespace Framework;

class Viewer
{
    public function render(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);

        require "views/$template";
    }
}