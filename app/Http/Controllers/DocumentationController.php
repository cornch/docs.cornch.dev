<?php

namespace App\Http\Controllers;

use App\Documentation\Loader;
use App\Documentation\Models\PathInfo;
use Illuminate\Contracts\View\View;

final class DocumentationController
{
    public function __invoke(string $locale, string $doc, string $version, string $page): View
    {
        $pathInfo = new PathInfo($doc, $locale, $version, $page);
        $loader = app(Loader::class, ['pathInfo' => $pathInfo]);

        return view('docs.show', [
            'pathInfo' => $pathInfo,
            'page' => $loader->getPage(),
        ]);
    }
}