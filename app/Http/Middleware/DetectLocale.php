<?php

namespace App\Http\Middleware;

use App\Enums\Locale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

final class DetectLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');

        if (is_string($locale) && ! empty($locale)) {
            $locale = Locale::tryFrom($locale);
        }

        if ($locale instanceof Locale) {
            App::setLocale($locale->toLaravelLocale());
        }

        return $next($request);
    }
}
