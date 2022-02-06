<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;

final class DocSidebar extends AbstractDocComponent
{
    public function render(): View
    {
        $html = $this->page->navigation;

        return view('components.doc-sidebar', [
            'html' => $html,
        ]);
    }
}
