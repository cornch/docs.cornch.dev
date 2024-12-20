<?php

declare(strict_types=1);

namespace App\Documentation;

use App\Documentation\Models\Docset;
use App\Documentation\Models\Page;
use App\Documentation\Models\PathInfo;
use App\Exceptions\LocaleNotFoundException;
use App\Markdown\DocumentationConverter;
use App\Markdown\NavigationConverter;
use App\Utils\Pipe;
use Closure;
use HTMLMin\HTMLMin\Facades\HTMLMin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Output\RenderedContentInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Wikimedia\CSS\Objects\CSSObject;
use Wikimedia\CSS\Parser\Parser as CSSParser;
use Wikimedia\CSS\Sanitizer\StylesheetSanitizer;

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
        'link-fixer' => Closure::class,
    ])]
    public readonly Docset $docset;

    public function __construct(
        public readonly PathInfo $pathInfo
    ) {
        $this->docset = Documentation::get($pathInfo->doc);

        if (! $this->docset->hasLocale($this->pathInfo->locale)) {
            throw new LocaleNotFoundException;
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
        return $this->docset->getLocale($this->pathInfo->locale)->title;
    }

    public function getPackageName(): string
    {
        return $this->docset->getLocale($this->pathInfo->locale)->packageName;
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
        return Cache
            ::remember(
                $this->getDocHash('page'),
                self::CACHE_TTL,
                function () {
                    $html = $this->parse()->getContent();
                    // $html = HTMLMin::html($html);
                    $html = $this->replaceStubStrings($html);

                    return new HtmlString($html);
                },
            );
    }

    public function getFrontMatter(): ?array
    {
        $parsed = $this->parse();

        if (! $parsed instanceof RenderedContentWithFrontMatter) {
            return null;
        }

        return $parsed->getFrontMatter();
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
                preg_match('@#([^#]+)\n@m', $markdown, $matches);

                return trim($matches[1] ?? '') . ' – ' . $this->getDocName();
            },
        );
    }

    public function getNavigation(): string
    {
        return Cache::remember(
            $this->getDocHash('nav'),
            self::CACHE_TTL,
            function () {
                $markdown = $this->getFile($this->replaceStubStrings($this->docset->getLocale($this->pathInfo->locale)->navigation));
                $markdown = $this->replaceStubStrings($markdown);

                $html = (new NavigationConverter($this->docset->linkFixer))->convert($markdown)->getContent();
                // $html = HTMLMin::html($html);

                return $this->replaceStubStrings($html);
            },
        );
    }

    private function parse(): RenderedContentInterface
    {
        $path = $this->resolveDocPath();

        //        return Cache
        //            ::remember(
        //                $this->getDocHash('markdown'),
        //                self::CACHE_TTL,
        //                function () use ($path) {
        $markdown = $this->getFile($path);
        $markdown = $this->replaceStubStrings($markdown);

        // remove style
        $markdown = preg_replace('#<style>[\w\W]+?</style>#', '', $markdown);

        return (new DocumentationConverter($this->docset->linkFixer))->convert($markdown);
        //                },
        //            );
    }

    private function getFile(string $path): string
    {
        return Storage::disk(self::DISK)->get($path) ??
            throw new NotFoundHttpException('Page not found');
    }

    private function resolveDocPath(): string
    {
        return $this->replaceStubStrings($this->docset->getLocale($this->pathInfo->locale)->path);
    }
}
