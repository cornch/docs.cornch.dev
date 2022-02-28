<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

final class DetectLocale
{
    private const DEFAULT_LOCALE = 'en';
    private const LOCALE_MAP = [
        'en' => 'en',
        'zh-tw' => 'zh_TW',
    ];

    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');
        if ($locale !== null) {
            App::setLocale(self::LOCALE_MAP[$locale] ?? self::DEFAULT_LOCALE);
        }

        return $next($request);
    }
}
