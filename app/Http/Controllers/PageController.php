<?php

namespace App\Http\Controllers;

use App\Enums\Locale;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

final class PageController
{
    public function about(Locale $locale): View
    {
        $markdown = File::get(resource_path('pages/about/' . basename($locale->value) . '.md'));
        $content = new HtmlString(Str::markdown($markdown));

        return view('page', [
            'title' => __('About this site'),
            'locale' => $locale,
            'content' => $content,
        ]);
    }
}
