<?php

declare(strict_types=1);

namespace App\Documentation\Models;

final class Locale
{
    public function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly string $title,
        public readonly string $packageName,
        public readonly string $path,
        public readonly string $navigation,
        public readonly bool $translated,
    ) {
    }
}
