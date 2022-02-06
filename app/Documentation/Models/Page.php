<?php

declare(strict_types=1);

namespace App\Documentation\Models;

use App\Documentation\Loader;
use Illuminate\Support\HtmlString;

final class Page
{
    public readonly PathInfo $pathInfo;

    public function __construct(
        public readonly Loader $loader,
        public readonly string|HtmlString $styles,
        public readonly string $title,
        public readonly string $navigation,
        public readonly string|HtmlString $content,
    ) {
        $this->pathInfo = $this->loader->pathInfo;
    }
}
