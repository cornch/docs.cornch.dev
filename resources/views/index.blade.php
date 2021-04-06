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
<header class="px-6 py-36 antialiased">
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
    <x-docs-list-item doc="laravel" class="flex justify-center items-stretch -mx-2">
        <x-slot name="logo">
            <x-logo.laravel class="w-full py-2" />
        </x-slot>
    </x-docs-list-item>
</div>

<footer class="container mx-auto px-6">
    <div class="text-center text-sm text-gray-600">
        <p>This software is licensed under AGPL-3.0-or-later. You can get a copy of it's source code from <a href="https://github.com/cornch/docs.cornch.dev" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="nofollow noopener">its GitHub repository</a>.</p>
    </div>
</footer>

<script src="{{ url('dist/js/app.js') }}"></script>
</body>
</html>
