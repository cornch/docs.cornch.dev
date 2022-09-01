<?php

declare(strict_types=1);

namespace App\Documentation\Models;

use App\Enums\Locale;
use JetBrains\PhpStorm\ArrayShape;

final class PathInfo
{
    public function __construct(
        public readonly string $doc,
        public readonly Locale $locale,
        public readonly string $version,
        public readonly string $page,
    ) {
    }

    #[ArrayShape(['doc' => "string", 'locale' => "string", 'version' => "string", 'page' => "string"])]
    public function toRouteParameters(array $extra = []): array
    {
        return [
            'doc' => $this->doc,
            'locale' => $this->locale->value,
            'version' => $this->version,
            'page' => $this->page,
            ...$extra,
        ];
    }

    public function toCacheKey(): string
    {
        return implode('-', [
            $this->doc,
            $this->locale->value,
            $this->version,
            $this->page,
        ]);
    }
}
