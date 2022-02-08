<?php

return [
    'docsets' => [
        'laravel' => [
            'header' => 'docs.headers.laravel',
            'footer' => 'docs.footers.laravel',
            'version' => true,
            'default_version' => '9.x',
            'locales' => [
                'zh-tw' => [
                    'name' => '繁體中文（臺灣）',
                    'title' => 'Laravel 繁體中文（臺灣）說明文件',
                    'path' => 'laravel/build/zh_TW/{{version}}/{{page}}.md',
                    'navigation' => 'laravel/build/zh_TW/{{version}}/documentation.md',
                ],
                'en' => [
                    'name' => 'English',
                    'title' => 'Laravel Documentation',
                    'path' => 'laravel/docs/{{version}}/{{page}}.md',
                    'navigation' => 'laravel/docs/{{version}}/documentation.md',
                ],
            ],
            'index' => 'installation',
            'versions' => [
                '8.x' => '8.x',
                '9.x' => '9.x',
                'Master' => 'master',
            ],
            'link-fixer' => function (string $url): string {
                return preg_replace(
                    ['#^/docs/#', '#^/api/#'],
                    ['/{{locale}}/laravel/', 'https://laravel.com/api/'],
                    $url
                );
            },
        ],
    ],
];
