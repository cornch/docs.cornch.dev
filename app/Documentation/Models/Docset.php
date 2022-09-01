<?php

declare(strict_types=1);

namespace App\Documentation\Models;

use App\Enums\Locale as LocaleEnum;
use Closure;

final class Docset
{
    public function __construct(
        public readonly string $headerView,
        public readonly string $footerView,
        public readonly bool $hasVersion,
        public readonly string $defaultVersion,
        public readonly array $locales,
        public readonly string $index,
        public readonly array $versions,
        public readonly array|Closure $linkFixer,
    ) {
    }

    public function hasLocale(LocaleEnum $locale): bool
    {
        return array_key_exists($locale->value, $this->locales);
    }

    public function getLocale(LocaleEnum $locale): ?Locale
    {
        return $this->locales[$locale->value] ?? null;
    }

    public function getVersion(string $version): ?Version
    {
        return $this->versions[$version] ?? null;
    }
}
