<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentationBasedRequest;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

final class DocumentationController
{
    private const COMMENTS_LIMIT = 3;

    private const CACHE_TTL_SECONDS = 60 * 15;

    public function __invoke(DocumentationBasedRequest $request): View
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
            'page' => $loader->getPage(),
            'comments' => $comments,
            'commentsCount' => $commentsCount,
        ]);
    }
}
