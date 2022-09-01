<?php

declare(strict_types=1);

namespace App\Documentation;

use App\Documentation\Models\Docset;

final class Documentation
{
    private static array $docsets = [];

    public static function register(string $id, Docset $docset): void
    {
        self::$docsets[$id] = $docset;
    }

    public static function get(string $id): ?Docset
    {
        return self::$docsets[$id] ?? null;
    }
}
