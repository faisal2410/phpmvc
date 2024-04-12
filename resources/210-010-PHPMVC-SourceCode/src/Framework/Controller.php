<?php

declare(strict_types=1);

namespace Framework;

abstract class Controller
{
    protected Request $request;

    protected PHPTemplateViewer $viewer;
    
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function setViewer(PHPTemplateViewer $viewer): void
    {
        $this->viewer = $viewer;
    }
}