<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Documentation\Models\Page;
use App\Documentation\Models\PathInfo;
use Illuminate\View\Component;

abstract class AbstractDocComponent extends Component
{
    public readonly PathInfo $pathInfo;

    public function __construct(
        public readonly Page $page
    ) {
        $this->pathInfo = $page->pathInfo;
    }
}
