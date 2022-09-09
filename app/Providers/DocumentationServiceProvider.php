<?php

declare(strict_types=1);

namespace App\Providers;

use App\Documentation\Documentation;
use App\Documentation\Models\Docset;
use App\Documentation\Models\Locale;
use App\Documentation\Models\Version;
use Illuminate\Support\ServiceProvider;

final class DocumentationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Documentation::register(
            'laravel',
            new Docset(
                headerView: 'docs.headers.laravel',
                footerView: 'docs.footers.laravel',
                hasVersion: true,
                defaultVersion: '9.x',
                locales: [
                    'en' => new Locale(
                        key: 'en',
                        name: 'English',
                        title: 'Laravel Documentation',
                        path: 'laravel/docs/{{version}}/{{page}}.md',
                        navigation: 'laravel/docs/{{version}}/documentation.md',
                        translated: false,
                    ),
                    'zh-tw' => new Locale(
                        key: 'zh_TW',
                        name: '繁體中文（臺灣）',
                        title: 'Laravel 繁體中文（臺灣）說明文件',
                        path: 'laravel/build/zh_TW/{{version}}/{{page}}.md',
                        navigation: 'laravel/build/zh_TW/{{version}}/documentation.md',
                        translated: true,
                    ),
                ],
                index: 'installation',
                versions: [
                    '8.x' => new Version(
                        key: '8.x',
                        name: '8.x',
                        old: true,
                        deprecated: false,
                        preRelease: false,
                    ),
                    '9.x' => new Version(
                        key: '9.x',
                        name: '9.x',
                        old: false,
                        deprecated: false,
                        preRelease: false,
                    ),
                    'master' => new Version(
                        key: 'master',
                        name: 'Master',
                        old: false,
                        deprecated: false,
                        preRelease: true,
                    ),
                ],
                linkFixer: function (string $url): string {
                    return preg_replace(
                        ['#^/docs/#', '#^/api/#'],
                        ['/{{locale}}/laravel/', 'https://laravel.com/api/'],
                        $url
                    );
                },
            )
        );
    }
}
