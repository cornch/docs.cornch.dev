<?php

namespace App\Http\Controllers;

use App\Documentation\Documentation;
use App\Documentation\Models\Locale;
use App\Documentation\Models\Version;
use App\Http\Requests\DocumentationBasedRequest;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

final class DocumentationController
{
    private const COMMENTS_LIMIT = 3;

    private const CACHE_TTL_SECONDS = 60 * 15;

    public function show(DocumentationBasedRequest $request): View
    {
        $loader = $request->getDocLoader();

        $comments = Cache::remember(
            'comments-doc:' . $loader->pathInfo->toCacheKey(),
            self::CACHE_TTL_SECONDS,
            static fn () => Comment
                ::byPathInfo($loader->pathInfo)
                    ->whereApproved()
                    ->limit(self::COMMENTS_LIMIT)
                    ->get(),
        );

        $commentsCount = Cache::remember(
            'comments-count:' . $loader->pathInfo->toCacheKey(),
            self::CACHE_TTL_SECONDS,
            static fn () => Comment::byPathInfo($loader->pathInfo)->whereApproved()->count(),
        );

        return view('docs.show', [
            'pathInfo' => $loader->pathInfo,
            'frontMatter' => $loader->getFrontMatter(),
            'page' => $loader->getPage(),
            'comments' => $comments,
            'commentsCount' => $commentsCount,
        ]);
    }

    public function detectsVersion($locale, string $doc, string $page): RedirectResponse
    {
        $docset = Documentation::get($doc);
        abort_if($docset === null, Response::HTTP_NOT_FOUND);

        // first try to find in non-pre-release versions
        $docLocale = $docset->getLocale($locale);
        abort_if($docLocale === null, Response::HTTP_NOT_FOUND);

        [$preReleasedVersions, $stableVersions] = collect($docset->versions)
            ->reverse()
            ->partition(static fn (Version $version) => $version->preRelease);

        foreach ($stableVersions as $version) {
            if (! $this->isPageInVersion($version, $docLocale, $doc, $page)) {
                continue;
            }

            return redirect()->route('docs.show', [
                'locale' => $locale->value,
                'doc' => $doc,
                'version' => $version->key,
                'page' => $page,
            ]);
        }

        // if not found, try to find in pre-release versions
        foreach ($preReleasedVersions as $version) {
            if ($this->isPageInVersion($version, $docLocale, $doc, $page)) {
                return redirect()->route('docs.show', [
                    'locale' => $locale->value,
                    'doc' => $doc,
                    'version' => $version->key,
                    'page' => $page,
                ]);
            }
        }

        abort(Response::HTTP_NOT_FOUND);
    }

    private function isPageInVersion(Version $version, Locale $locale, string $doc, string $page): bool
    {
        $path = $locale->path;

        return File::exists(
            resource_path(
                'docs/' .
                str_replace(
                    ['{{version}}', '{{page}}'],
                    [$version->key, $page],
                    $path
                ),
            ),
        );
    }
}
