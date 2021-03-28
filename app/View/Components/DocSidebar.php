<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class DocSidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $doc
     * @param string $version
     */
    public function __construct(
        public string $doc,
        public string $version
    ) {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $navFile = config("docs.docsets.{$this->doc}.navigation");

        if ($navFile === null) {
            return '';
        }

        $navFile = config("docs.docsets.{$this->doc}.folder") . '/' . $this->version . '/' . $navFile;

        $markdown = Storage::disk('docs')->get($navFile);

        return view('components.doc-sidebar', [
            'markdown' => $markdown,
        ]);
    }
}
