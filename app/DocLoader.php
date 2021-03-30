<?php

declare(strict_types=1);

namespace App;

use App\CommonMark\DocumentationConverter;
use App\CommonMark\NavigationConverter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;

final class DocLoader
{
    private const DISK = 'docs';

    private string $doc;
    private string $page;
    private string $version;
    private string $locale;

    #[ArrayShape([
        'name' => 'string',
        'path' => 'string',
        'navigation' => 'string',
        'link-fixer' => \Closure::class
    ])]
    private array $config;

    /**
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     * @noinspection NullPointerExceptionInspection
     */
    public function __construct(?string $doc = null, ?string $locale = null, ?string $version = null, ?string $page = null)
    {
        $currentRoute = Route::current();
        $this->doc = $doc ?? $currentRoute->parameter('doc');
        $this->locale = $locale ?? $currentRoute->parameter('locale');
        $this->version = $version ?? $currentRoute->parameter('version');
        $this->page = $page ?? $currentRoute->parameter('page');

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
        return Storage::disk(self::DISK)->get($path);
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
