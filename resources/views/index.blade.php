<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ url('dist/css/app.css') }}">
</head>

<body>
<header class="px-6 py-16 md:py-36 antialiased">
    <div class="flex flex-col justify-center items-center">
        <x-logo class="w-48 mx-2" />
        <a
            href="/"
            class="block text-2xl lg:inline-block font-black font-mono"
        >
            \Cornch\Docs::class
        </a>
    </div>
</header>

<div class="container mx-auto px-6 mb-36">
    <x-docs-list-item doc="laravel" class="flex flex-col md:flex-row justify-center items-center md:items-stretch md:-mx-2">
        <x-slot name="logo">
            <x-logo.laravel class="w-64 md:w-full py-2" />
        </x-slot>
    </x-docs-list-item>
</div>

<footer class="container mx-auto px-6 mb-16">
    <div class="w-full rounded bg-warmGray-200 py-4">
        <div class="text-center text-sm text-gray-600">
            <p>&quot;Laravel&quot; is a Trademark of Taylor Otwell.</p>
            <p>This software is licensed under AGPL-3.0-or-later. You can get a copy of it's source code from <a href="https://github.com/cornch/docs.cornch.dev" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="nofollow noopener">its GitHub repository</a>.</p>
            <p>cornch.dev &copy; {{ date('Y') }} All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="{{ url('dist/js/app.js') }}"></script>
</body>
</html>
