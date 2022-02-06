<?php

declare(strict_types=1);

namespace App\Documentation\Models;

use JetBrains\PhpStorm\ArrayShape;

final class PathInfo
{
    public function __construct(
        public readonly string $doc,
        public readonly string $locale,
        public readonly string $version,
        public readonly string $page,
    ) {
    }

    #[ArrayShape(['doc' => "string", 'locale' => "string", 'version' => "string", 'page' => "string"])]
    public function toRouteParameters(): array
    {
        return [
            'doc' => $this->doc,
            'locale' => $this->locale,
            'version' => $this->version,
            'page' => $this->page,
        ];
    }
}
