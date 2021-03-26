<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class DocsController
{
    public function show(string $doc, ?string $version, string $page): View
    {
        $markdown = $this->getPage($doc, $version, $page);

        return view('docs.show', [
            'doc' => $doc,
            'version' => $version,
            'markdown' => $markdown
        ]);
    }

    private function getPage(string $doc, ?string $version, string $page): string
    {
        $docFolder = $this->getDocFolder($doc);

        $pageFolder = dirname($page);
        $pageFolder = $pageFolder === '.' ? '' : $pageFolder;
        $pageFolder = trim($version . '/' . $pageFolder, '/');
        $pageName = basename($page);

        $fileName = "{$docFolder}/{$pageFolder}/{$pageName}.md";

        return Storage::disk('docs')->get($fileName);
    }

    private function getDocFolder(string $doc): ?string
    {
        return config("docs.docsets.{$doc}.folder");
    }
}
