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
        return once(fn () => collect($this->loader->config['locales'])
            ->map(fn (array $config, $code) => [
                'name' => $config['name'],
                'code' => $code,
                'url' => route('docs.show', [
                    ...$this->pathInfo->toRouteParameters(),
                    'locale' => $code,
                ]),
            ])
            ->toArray());
    }

    public function version(): ?string
    {
        return $this->loader->config['versions'][$this->pathInfo->version] ?? null;
    }

    public function versions(): array
    {
        return once(fn () => collect($this->loader->config['versions'])
            ->map(fn (string $name, string $code) => [
                'name' => $name,
                'code' => $code,
                'url' => route('docs.show', [
                    ...$this->pathInfo->toRouteParameters(),
                    'version' => $code,
                ]),
            ])
            ->values()
            ->toArray());
    }
}
