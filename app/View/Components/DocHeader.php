<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;

final class DocHeader extends AbstractDocComponent
{
    public function render(): View
    {
        $view = $this->page->loader->config['header'];
        $locales = collect($this->page->loader->config['locales'])
            ->map(fn (array $config, $code) => [
                'name' => $config['name'],
                'url' => route('docs.show', [
                    ...$this->page->pathInfo->toRouteParameters(),
                    'locale' => $code,
                ]),
            ])
            ->toArray();

        return view($view, [
            'versions' => $this->page->loader->config['versions'],
            'locales' => $locales,
            'versionUrl' => route('docs.show', [
                ...$this->page->pathInfo->toRouteParameters(),
                'version' => '__version__',
            ])
        ]);
    }
}
