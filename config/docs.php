<?php

return [
    'docsets' => [
        'laravel' => [
            'name' => 'Laravel',
            'path' => 'laravel/build/{{locale}}/{{version}}/{{page}}.md',
            'version' => true,
            'navigation' => 'laravel/build/{{locale}}/{{version}}/documentation.md',
            'link-fixer' => function (string $url): string {
                return preg_replace('#^/docs/#', '/{{locale}}/laravel/', $url);
            },
        ],
    ],
];
