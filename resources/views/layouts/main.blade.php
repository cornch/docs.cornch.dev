<!doctype html>
@if (app('view')->hasSection('lang'))
    <html lang="@yield('lang')">
@else
    <html>
@endif

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(app('view')->hasSection('title'))
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <link rel="stylesheet" href="{{ url('dist/css/app.css') }}">

    @stack('header-styles')
</head>

<body>
<header class="container mx-auto px-6 antialiased">
    <nav class="flex flex-wrap items-center justify-between lg:justify-start py-1">
        <div class="inline-flex items-center -mx-2">
            <x-logo class="w-12 mx-2" />
            @empty ($doc)
                <a href="/" class="block mx-2 text-xl lg:inline-block mr-12 font-black font-mono">\Cornch\Docs::class</a>
            @else
                <a href="/" class="block mx-2 text-xl lg:inline-block mr-12 font-black font-mono">\Cornch\Docs\{{ \Illuminate\Support\Str::of($doc)->camel()->ucfirst() }}::class</a>
            @endempty
        </div>
    </nav>
</header>

<div class="mb-16">
    @yield('content')
</div>

<footer class="container mx-auto px-6 mb-16">
    <div class="w-full rounded bg-warmGray-200 py-4">
        <div class="text-center text-sm text-gray-600">
            <p>This software is licensed under AGPL-3.0-or-later. You can get a copy of it's source code from <a href="https://github.com/cornch/docs.cornch.dev" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="nofollow noopener">its GitHub repository</a>.</p>
            <p>cornch.dev &copy; {{ date('Y') }} All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="{{ url('dist/js/app.js') }}"></script>
</body>
</html>
