<?php

declare(strict_types=1);

namespace App;

use App\CommonMark\DocumentationConverter;
use App\CommonMark\NavigationConverter;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\ArrayShape;

final class DocLoader
{
    private const DISK = 'docs';

    #[ArrayShape([
        'name' => 'string',
        'path' => 'string',
        'navigation' => 'string',
        'header' => 'string',
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
                $this->resolveLocale($replace['locale'] ?? $this->locale),
                $replace['version'] ?? $this->version,
                $replace['page'] ?? $this->page
            ],
            $string,
        );
    }

    public function getDocName(): string
    {
        return $this->config['name'];
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
        $markdown = $this->getFile($this->replaceStubStrings($this->config['navigation']));
        $markdown = $this->replaceStubStrings($markdown);
        $html = (new NavigationConverter($this->config['link-fixer']))->convertToHtml($markdown);

        return $this->replaceStubStrings($html);
    }

    private function getFile(string $path): string
    {
        return app('filesystem')->disk(self::DISK)->get($path);
    }

    public function getHeader(): View
    {
        $view = $this->config['header'];

        return view($view, [
            'versions' => $this->config['versions'],
            'version' => $this->version,
            'locale' => $this->locale,
            'page' => $this->page,
            'versionUrl' => route('docs.show', ['version' => '__version__', 'locale' => $this->locale, 'doc' => $this->doc, 'page' => $this->page])
        ]);
    }

    private function resolveDocPath(): string
    {
        return $this->replaceStubStrings($this->config['path']);
    }

    /**
     * Take care of locale format.
     * Replace something like zh-tw to zh_TW.
     *
     * @param string $locale
     * @return string
     */
    private function resolveLocale(string $locale): string
    {
        [$first, $second] = explode('_', str_replace('-', '_', $locale));

        return strtolower($first) . '_' . strtoupper($second);
    }
}
