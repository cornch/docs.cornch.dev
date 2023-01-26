<?php

declare(strict_types=1);

namespace App\Documentation\Models;

use App\Enums\Locale as LocaleEnum;
use Closure;
use InvalidArgumentException;

final class Docset
{
    /**
     * @param  string  $headerView
     * @param  string  $footerView
     * @param  bool  $hasVersion
     * @param  string  $defaultVersion
     * @param  array<string, Locale>  $locales
     * @param  string  $index
     * @param  array<string, Version>  $versions
     * @param  array|Closure  $linkFixer
     */
    public function __construct(
        public readonly string $headerView,
        public readonly string $footerView,
        public readonly bool $hasVersion,
        public readonly string $defaultVersion,
        public readonly array $locales,
        public readonly string $index,
        public readonly array $versions,
        public readonly string $currentVersion,
        public readonly array|Closure $linkFixer,
    ) {
        if (! array_key_exists($defaultVersion, $versions)) {
            throw new InvalidArgumentException("The current version [{$defaultVersion}] is not defined.");
        }
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
