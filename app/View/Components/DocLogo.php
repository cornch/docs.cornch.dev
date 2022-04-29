<?php

namespace App\View\Components;

class DocLogo extends AbstractDocComponent
{
    public function render()
    {
        return view('components.logo.' . $this->page->pathInfo->doc);
    }
}
