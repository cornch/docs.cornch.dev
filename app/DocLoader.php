<?php

declare(strict_types=1);

namespace App;

use App\CommonMark\DocumentationConverter;
use App\CommonMark\NavigationConverter;
use App\Exceptions\LocaleNotFoundException;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\ArrayShape;

final class DocLoader
{
    private const DISK = 'docs';

    #[ArrayShape([
        'name' => 'string',
        'locales' => 'array',
        'header' => 'string',
        'footer' => 'string',
        'versions' => 'array',
        'link-fixer' => \Closure::class
    ])]
    private array $config;

    /**
     * @param string $doc
     * @param string $locale
     * @param string $version
     * @param string $page
     */
    public function __construct(
        private string $doc,
        private string $locale,
        private string $version,
        private string $page
    ) {
        $this->config = config("docs.docsets.{$this->doc}");

        if (!array_key_exists($this->locale, $this->config['locales'])) {
            throw new LocaleNotFoundException();
        }
    }

    public function replaceStubStrings(
        $string,
        #[ArrayShape(['doc' => 'string|null', 'locale' => 'string|null', 'version' => 'string|null', 'page' => 'string|null'])]
        array $replace = []
    ): string
    {
        return str_replace(
            ['{{doc}}', '{{locale}}', '{{version}}', '{{page}}'],
            [
                $replace['doc'] ?? $this->doc,
                $replace['locale'] ?? $this->locale,
                $replace['version'] ?? $this->version,
                $replace['page'] ?? $this->page
            ],
            $string,
        );
    }

    public function getDocName(): string
    {
        return $this->config['locales'][$this->locale]['title'];
    }

    public function getLocales(): array
    {
        return $this->config['locales'];
    }

    public function getPage(): string
    {
        $path = $this->resolveDocPath();

        $markdown = $this->getFile($path);
        $markdown = $this->replaceStubStrings($markdown);
        $html = (new DocumentationConverter($this->config['link-fixer']))->convertToHtml($markdown);

        return $this->replaceStubStrings($html);
    }

    public function getPageTitle(): string
    {
        $markdown = $this->getFile($this->resolveDocPath());

        $matches = [];
        preg_match('@^#([^#]+)\n@', $markdown, $matches);

        return trim($matches[1] ?? '') . ' - ' . $this->getDocName();
    }

    public function getNavigation(): string
    {
        $markdown = $this->getFile($this->replaceStubStrings($this->config['locales'][$this->locale]['navigation']));
        $markdown = $this->replaceStubStrings($markdown);
        $html = (new NavigationConverter($this->config['link-fixer']))->convertToHtml($markdown);

        return $this->replaceStubStrings($html);
    }

    public function getHeader(): View
    {
        $view = $this->config['header'];
        $locales = collect($this->config['locales'])
            ->map(function (array $config, $code): array {
                return [
                    'name' => $config['name'],
                    'url' => route('docs.show', ['version' => $this->version, 'locale' => $code, 'doc' => $this->doc, 'page' => $this->page]),
                ];
            })
            ->toArray();

        return view($view, [
            'versions' => $this->config['versions'],
            'locales' => $locales,
            'version' => $this->version,
            'locale' => $this->locale,
            'page' => $this->page,
            'versionUrl' => route('docs.show', ['version' => '__version__', 'locale' => $this->locale, 'doc' => $this->doc, 'page' => $this->page])
        ]);
    }

    public function getFooter(): View
    {
        $view = $this->config['footer'];

        return view($view, [
            'version' => $this->version,
            'locale' => $this->locale,
            'page' => $this->page,
        ]);
    }

    private function getFile(string $path): string
    {
        return app('filesystem')->disk(self::DISK)->get($path);
    }

    private function resolveDocPath(): string
    {
        return $this->replaceStubStrings($this->config['locales'][$this->locale]['path']);
    }
}
