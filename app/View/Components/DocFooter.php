<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;

final class DocFooter extends AbstractDocComponent
{
    public function render(): View
    {
        return $this->docLoader->getFooter();
    }
}
