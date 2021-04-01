<?php

return [
    'docsets' => [
        'laravel' => [
            'name' => 'Laravel Documentation',
            'path' => 'laravel/build/{{locale}}/{{version}}/{{page}}.md',
            'navigation' => 'laravel/build/{{locale}}/{{version}}/documentation.md',
            'header' => 'docs.headers.laravel',
            'version' => true,
            'default_version' => '8.x',
            'versions' => [
                '8.x' => '8.x',
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
