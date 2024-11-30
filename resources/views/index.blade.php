<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-plausible />
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

<div class="container mx-auto px-6 mb-36" x-data="{ showDeprecated: false, showPreRelease: false }">
    <div class="mb-6 flex justify-center md:justify-start gap-4 px-6">
        <div class="flex items-center gap-2">
            <input type="checkbox" id="show-deprecated" x-model="showDeprecated" class="form-checkbox" />
            <label for="show-deprecated">
                {{ __('Deprecated') }}
            </label>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" id="show-pre-release" x-model="showPreRelease" class="form-checkbox" />
            <label for="show-pre-release">
                {{ __('Pre-Release') }}
            </label>
        </div>
    </div>

    <x-docs-list-item doc="laravel" class="flex flex-col md:flex-row justify-center items-center md:items-stretch md:-mx-2">
        <x-slot name="logo">
            <x-logo.laravel class="w-64 md:w-full py-2" />
        </x-slot>
    </x-docs-list-item>
</div>

<footer class="container mx-auto px-6 mb-16">
    <div class="w-full rounded-sm bg-zinc-200 dark:bg-zinc-600 py-4">
        <div class="text-center text-sm text-gray-600 dark:text-gray-400">
            <p>&quot;Laravel&quot; is a Trademark of Taylor Otwell.</p>
            <p>This software is licensed under AGPL-3.0-or-later. You can get a copy of its source code from <a href="https://github.com/cornch/docs.cornch.dev" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="nofollow noopener">its GitHub repository</a>.</p>
            <p>cornch.dev &copy; {{ date('Y') }} All Rights Reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>
