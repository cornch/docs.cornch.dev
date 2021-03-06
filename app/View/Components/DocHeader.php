<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;

final class DocHeader extends AbstractDocComponent
{
    public function render(): View
    {
        return $this->docLoader->getHeader();
    }
}
