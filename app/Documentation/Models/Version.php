<?php

declare(strict_types=1);

namespace App\Documentation\Models;

final class Version
{
    public function __construct(
        public readonly string $name,
        public readonly bool $old,
        public readonly bool $deprecated,
        public readonly bool $preRelease,
    ) {
    }
}
