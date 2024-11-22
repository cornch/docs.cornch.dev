<?php

declare(strict_types=1);

namespace App\Providers;

use App\Documentation\Documentation;
use App\Documentation\Models\Docset;
use App\Documentation\Models\Locale;
use App\Documentation\Models\Version;
use DateTime;
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
                defaultVersion: '11.x',
                locales: [
                    'en' => new Locale(
                        key: 'en',
                        name: 'English',
                        title: 'Laravel Documentation',
                        packageName: 'Laravel Framework',
                        path: 'laravel/docs/{{version}}/{{page}}.md',
                        navigation: 'laravel/docs/{{version}}/documentation.md',
                        translated: false,
                    ),
                    'zh-tw' => new Locale(
                        key: 'zh_TW',
                        name: '繁體中文（臺灣）',
                        title: 'Laravel 繁體中文（臺灣）說明文件',
                        packageName: 'Laravel Framework',
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
                        bugFixSupportEndsAt: new DateTime('2022-07-26T00:00:00+00:00'),
                        securitySupportEndsAt: new DateTime('2023-01-24T00:00:00+00:00'),
                        preRelease: false,
                    ),
                    '9.x' => new Version(
                        key: '9.x',
                        name: '9.x',
                        bugFixSupportEndsAt: new DateTime('2023-08-08T00:00:00+00:00'),
                        securitySupportEndsAt: new DateTime('2024-02-08T00:00:00+00:00'),
                        preRelease: false,
                    ),
                    '10.x' => new Version(
                        key: '10.x',
                        name: '10.x',
                        bugFixSupportEndsAt: new DateTime('2024-08-07T00:00:00+00:00'),
                        securitySupportEndsAt: new DateTime('2025-02-05T00:00:00+00:00'),
                        preRelease: false,
                    ),
                    '11.x' => new Version(
                        key: '11.x',
                        name: '11.x',
                        bugFixSupportEndsAt: new DateTime('2025-09-03T00:00:00+00:00'),
                        securitySupportEndsAt: new DateTime('2026-03-12T00:00:00+00:00'),
                        preRelease: false,
                    ),
                    'master' => new Version(
                        key: 'master',
                        name: 'Master',
                        bugFixSupportEndsAt: null,
                        securitySupportEndsAt: null,
                        preRelease: true,
                    ),
                ],
                currentVersion: '11.x',
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
