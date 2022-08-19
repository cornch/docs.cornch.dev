<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Documentation\Loader;
use App\Documentation\Models\PathInfo;
use App\Enums\Locale;
use App\Http\Requests\DocumentationBasedRequest;
use Illuminate\Contracts\View\View;
use Mews\Captcha\Captcha;

final class CommentController
{
    public function __construct(
        private readonly Captcha $captcha
    ) {
    }

    public function form(DocumentationBasedRequest $request): View
    {
        $loader = $request->getDocLoader();
        $captcha = $this->captcha->create(api: true);

        return view('comments.form', [
            'pathInfo' => $loader->pathInfo,
            'page' => $loader->getPage(),
            'captcha' => $captcha,
        ]);
    }
}
