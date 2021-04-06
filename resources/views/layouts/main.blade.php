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

<div>
    @yield('content')
</div>

<script src="{{ url('dist/js/app.js') }}"></script>
</body>
</html>
