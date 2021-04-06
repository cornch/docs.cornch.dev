<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;

final class DocSidebar extends AbstractDocComponent
{
    public function render(): View
    {
        $html = $this->docLoader->getNavigation();

        return view('components.doc-sidebar', [
            'html' => $html,
        ]);
    }
}
