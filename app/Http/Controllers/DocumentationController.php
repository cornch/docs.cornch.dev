<?php

namespace App\Http\Controllers;

use App\Documentation\Loader;
use App\Documentation\Models\PathInfo;
use App\Enums\Locale;
use App\Http\Requests\DocumentationBasedRequest;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

final class DocumentationController
{
    public function __invoke(DocumentationBasedRequest $request): View
    {
        $loader = $request->getDocLoader();

        $comments = Comment
            ::byPathInfo($loader->pathInfo)
            ->whereApproved()
            ->get();

        return view('docs.show', [
            'pathInfo' => $loader->pathInfo,
            'page' => $loader->getPage(),
            'comments' => $comments,
        ]);
    }
}
