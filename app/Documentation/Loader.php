<?php

declare(strict_types=1);

namespace App\Documentation;

use App\CommonMark\DocumentationConverter;
use App\CommonMark\NavigationConverter;
use App\Documentation\Models\Page;
use App\Documentation\Models\PathInfo;
use App\Exceptions\LocaleNotFoundException;
use App\Utils\Pipe;
use Closure;
use HTMLMin\HTMLMin\Facades\HTMLMin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Wikimedia\CSS\Objects\CSSObject;
use Wikimedia\CSS\Parser\Parser as CSSParser;

use Wikimedia\CSS\Sanitizer\StylesheetSanitizer;

use function config;
use function once;

final class Loader
{
    private const CACHE_TTL = 60 * 60 * 24;
    private const DISK = 'docs';

    #[ArrayShape([
        'name' => 'string',
        'locales' => 'array',
        'header' => 'string',
        'footer' => 'string',
        'versions' => 'array',
        'link-fixer' => Closure::class
    ])]
    public readonly array $config;

    public function __construct(
        public readonly PathInfo $pathInfo
    ) {
        $this->config = config("docs.docsets.{$this->pathInfo->doc}");

        if (!array_key_exists($this->pathInfo->locale->value, $this->config['locales'])) {
            throw new LocaleNotFoundException();
        }
    }

    public function replaceStubStrings(
        $string,
        #[ArrayShape(['doc' => 'string|null', 'locale' => 'string|null', 'version' => 'string|null', 'page' => 'string|null'])]
        array $replace = []
    ): string {
        return str_replace(
            ['{{doc}}', '{{locale}}', '{{version}}', '{{page}}'],
            [
                $replace['doc'] ?? $this->pathInfo->doc,
                $replace['locale'] ?? $this->pathInfo->locale->value,
                $replace['version'] ?? $this->pathInfo->version,
                $replace['page'] ?? $this->pathInfo->page,
            ],
            $string,
        );
    }

    public function getDocHash(string $prefix): string
    {
        return $prefix . '-' . once(function (): string {
            $path = $this->resolveDocPath();
            return md5($path);
        });
    }

    public function getDocName(): string
    {
        return $this->config['locales'][$this->pathInfo->locale->value]['title'];
    }

    public function getLocales(): array
    {
        return $this->config['locales'];
    }

    public function getPage(): Page
    {
        return new Page(
            loader: $this,
            styles: $this->getStyle(),
            title: $this->getPageTitle(),
            navigation: $this->getNavigation(),
            content: $this->getContent(),
        );
    }

    public function getContent(): HtmlString
    {
        $path = $this->resolveDocPath();

        return Cache
            ::remember(
                $this->getDocHash('page'),
                self::CACHE_TTL,
                function () use ($path) {
                    $markdown = $this->getFile($path);
                    $markdown = $this->replaceStubStrings($markdown);

                    // remove style
                    $markdown = preg_replace('#<style>[\w\W]+?</style>#', '', $markdown);

                    $html = (new DocumentationConverter($this->config['link-fixer']))->convert($markdown)->getContent();
                    $html = HTMLMin::html($html);
                    $html = $this->replaceStubStrings($html);

                    return new HtmlString($html);
                },
            );
    }

    public function getStyle(): HtmlString
    {
        $path = $this->resolveDocPath();

        return Cache
            ::remember(
                $this->getDocHash('style'),
                self::CACHE_TTL,
                fn () => Pipe::from($this->getFile($path))
                    (static fn (string $c) => Str::matchAll('#<style>([\w\W]+?)</style>#', $c)->implode(''))
                    ([CSSParser::class, 'newFromString'])
                    (static fn (CSSParser $p) => $p->parseStylesheet())
                    (static fn (CSSObject $parser) => StylesheetSanitizer::newDefault()->sanitize($parser))
                    (static fn ($css) => new HtmlString((string) $css))
                    ->endpipe,
            );
    }

    public function getPageTitle(): string
    {
        return Cache::remember(
            $this->getDocHash('title'),
            self::CACHE_TTL,
            function () {
                $markdown = $this->getFile($this->resolveDocPath());

                $matches = [];
                preg_match('@^#([^#]+)\n@', $markdown, $matches);

                return trim($matches[1] ?? '') . ' - ' . $this->getDocName();
            },
        );
    }

    public function getNavigation(): string
    {
        return Cache::remember(
            $this->getDocHash('nav'),
            self::CACHE_TTL,
            function () {
                $markdown = $this->getFile($this->replaceStubStrings($this->config['locales'][$this->pathInfo->locale->value]['navigation']));
                $markdown = $this->replaceStubStrings($markdown);

                $html = (new NavigationConverter($this->config['link-fixer']))->convert($markdown)->getContent();
                $html = HTMLMin::html($html);

                return $this->replaceStubStrings($html);
            },
        );
    }

    private function getFile(string $path): string
    {
        return Storage::disk(self::DISK)->get($path) ??
            throw new NotFoundHttpException('Page not found');
    }

    private function resolveDocPath(): string
    {
        return $this->replaceStubStrings($this->config['locales'][$this->pathInfo->locale->value]['path']);
    }
}
