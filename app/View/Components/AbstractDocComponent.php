<?php

declare(strict_types=1);

namespace App\View\Components;

use App\DocLoader;
use Illuminate\View\Component;

abstract class AbstractDocComponent extends Component
{
    protected DocLoader $docLoader;

    public function __construct(
        public string $locale,
        public string $doc,
        public string $version,
        public string $page
    ) {
        $this->docLoader = app(DocLoader::class, [
            'locale' => $this->locale,
            'doc' => $this->doc,
            'version' => $this->version,
            'page' => $this->page,
        ]);
    }
}
