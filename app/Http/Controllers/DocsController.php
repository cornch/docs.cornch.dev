<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DocLoader;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

final class DocsController
{
    public function __construct(
        private DocLoader $docLoader
    ) {
    }

    public function show(string $locale, string $doc, ?string $version, string $page): View
    {
        $title = $this->docLoader->getPageTitle($doc, $page, $version);
        $content = $this->docLoader->getPage($doc, $page, $version);

        return view('docs.show', [
            'title' => $title,
            'doc' => $doc,
            'locale' => $locale,
            'version' => $version,
            'content' => $content,
        ]);
    }

    private function getPage(string $doc, string $locale, ?string $version, string $page): string
    {
        $path = config("docs.docsets.{$doc}.path");

        $pageFolder = dirname($page);
        $pageName = trim(($pageFolder === '.' ? '' : $pageFolder) . '/' . basename($page), '/');

        $fileName = str_replace(
            ['{{locale}}', '{{version}}', '{{page}}'],
            [$locale, $version, $pageName],
            $path,
        );

        return Storage::disk('docs')->get($fileName);
    }
}
