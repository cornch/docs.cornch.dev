<?php

namespace App\View\Components;

use App\DocLoader;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

final class DocSidebar extends Component
{
    public function __construct(
        public string $locale,
        public string $doc,
        public string $version,
        public string $page
    ) {
    }

    public function render(): View
    {
        $docLoader = app(DocLoader::class, [
            'locale' => $this->locale,
            'doc' => $this->doc,
            'version' => $this->version,
            'page' => $this->page,
        ]);

        $html = $docLoader->getNavigation();

        return view('components.doc-sidebar', [
            'html' => $html,
        ]);
    }
}
