<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

final class DocsController
{
    public function show(string $locale, string $doc, ?string $version, string $page): View
    {
        $markdown = $this->getPage($doc, $locale, $version, $page);

        return view('docs.show', [
            'doc' => $doc,
            'locale' => $locale,
            'version' => $version,
            'markdown' => $markdown
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
