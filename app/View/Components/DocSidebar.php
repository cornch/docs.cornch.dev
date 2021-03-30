<?php

namespace App\View\Components;

use App\DocLoader;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class DocSidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @param \App\DocLoader $docLoader
     * @param string|null $locale
     * @param string|null $doc
     * @param string|null $version
     */
    public function __construct(
        public string $locale,
        public string $doc,
        public string $version,
        public string $page
    ) {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
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
