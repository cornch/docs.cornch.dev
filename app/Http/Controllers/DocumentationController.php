<?php

namespace App\Http\Controllers;

use App\Documentation\Loader;
use App\Documentation\Models\PathInfo;
use App\Enums\Locale;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

final class DocumentationController
{
    public function __invoke(Locale $locale, string $doc, string $version, string $page): View
    {
        $pathInfo = new PathInfo($doc, $locale, $version, $page);
        $loader = app(Loader::class, ['pathInfo' => $pathInfo]);

        $comments = Comment
            ::query()
            ->where('locale', $locale->value)
            ->where('doc', $doc)
            ->where('page', $page)
            ->whereApproved()
            ->get();

        return view('docs.show', [
            'pathInfo' => $pathInfo,
            'page' => $loader->getPage(),
            'comments' => $comments,
        ]);
    }
}
