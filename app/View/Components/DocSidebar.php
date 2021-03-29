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
        private DocLoader $docLoader,
        public ?string $locale = null,
        public ?string $doc = null,
        public ?string $version = null
    ) {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $html = $this->docLoader->getNavigation($this->doc, $this->version);

        return view('components.doc-sidebar', [
            'html' => $html,
        ]);
    }
}
