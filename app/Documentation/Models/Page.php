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

    public function locales(): array
    {
        return once(fn () => collect($this->loader->docset->locales)
            ->map(fn (Locale $locale, $code) => [
                'name' => $locale->name,
                'code' => $code,
                'url' => route(
                    'docs.show',
                    $this->pathInfo->toRouteParameters([
                        'locale' => $code,
                    ]),
                ),
            ])
            ->toArray());
    }

    public function version(): ?string
    {
        return $this->loader->docset->getVersion($this->pathInfo->version)?->name ?? null;
    }

    public function versions(): array
    {
        return once(fn () => collect($this->loader->docset->versions)
            ->map(fn (Version $version, string $code) => [
                'name' => $version->name,
                'code' => $code,
                'url' => route(
                    'docs.show',
                    $this->pathInfo->toRouteParameters([
                        'version' => $code,
                    ]),
                ),
            ])
            ->values()
            ->toArray());
    }
}
