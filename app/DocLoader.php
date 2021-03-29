<?php

declare(strict_types=1);

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

final class DocLoader
{
    private const DISK = 'docs';

    private string $doc;
    private string $page;
    private string $version;
    private string $locale;

    public function __construct(\Illuminate\Routing\Router $route)
    {
        $currentRoute = $route->current();
        $this->doc = $currentRoute->parameter('doc');
        $this->locale = $currentRoute->parameter('locale');
        $this->version = $currentRoute->parameter('version');
        $this->page = $currentRoute->parameter('page');
    }

    public function getPage($doc = null, $page = null, $version = null): string
    {
        $docName = $doc ?? $this->doc;

        $path = config("docs.docsets.{$docName}.path");
        if ($path === null) {
            throw new \RuntimeException("Unknown doc: {$docName}");
        }

        $path = $this->replaceStubStrings($path, ['doc' => $doc, 'page' => $page, 'version' => $version]);

        $markdown = $this->getFile($path);
        return $this->replaceStubStrings($markdown, ['doc' => $doc, 'page' => $page, 'version' => $version]);
    }

    public function getNavigation($doc = null, $version = null): string
    {
        $docName = $doc ?? $this->doc;

        $nav = config("docs.docsets.{$docName}.navigation");

        if ($nav === null) {
            throw new \RuntimeException("Unkown doc: {$docName}");
        }

        $nav = $this->replaceStubStrings($nav, ['doc' => $doc, 'version' => $version]);
        $markdown = $this->getFile($nav);

        return $this->replaceStubStrings($markdown, ['doc' => $doc, 'version' => $version]);
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

    private function getFile($path)
    {
        return Storage::disk(self::DISK)->get($path);
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
