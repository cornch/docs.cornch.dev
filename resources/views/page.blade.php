<!doctype html>
<html lang="{{ $locale->toBcp47() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-plausible />
</head>

<body>
<header class="container mx-auto px-6 py-4 md:py-6 antialiased">
    <div class="flex flex justify-start items-center gap-2">
        <x-logo class="w-24" />
        <a
            href="/"
            class="block text-2xl lg:inline-block font-black font-mono"
        >
            \Cornch\Docs::class
        </a>
    </div>
</header>

<div class="container mx-auto px-6 mb-36">
    <article class="content prose dark:prose-invert">
        {{ $content }}
    </article>
</div>

<footer class="container mx-auto px-6 mb-16">
    <div class="w-full rounded-sm bg-zinc-200 dark:bg-zinc-600 py-4">
        <div class="text-center text-sm text-gray-600 dark:text-gray-400">
            <p>This software is licensed under AGPL-3.0-or-later. You can get a copy of its source code from <a href="https://github.com/cornch/docs.cornch.dev" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="nofollow noopener">its GitHub repository</a>.</p>
            <p>cornch.dev &copy; {{ date('Y') }} All Rights Reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>
