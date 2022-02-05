<?php

namespace App\Http\Controllers;

use App\DocLoader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class DocumentationController extends Controller
{
    public function __invoke(string $locale, string $doc, string $version, string $page): View
    {
        $docLoader = app(DocLoader::class, compact('locale', 'doc', 'version', 'page'));

        return view('docs.show', [
            'title' => $docLoader->getPageTitle(),
            'content' => $docLoader->getPage(),
            'style' => $docLoader->getStyle(),
            'locale' => $locale,
            'doc' => $doc,
            'version' => $version,
            'page' => $page,
        ]);
    }
}
