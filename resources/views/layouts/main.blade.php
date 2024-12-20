<?php /** @var \App\Documentation\Models\Page $page */ ?>
<?php /** @var \App\Documentation\Models\PathInfo $pathInfo */ ?>

<!doctype html>
@if (View::hasSection('lang'))
    <html lang="@yield('lang')">
@else
    <html lang="en">
@endif

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(View::hasSection('title'))
        <title>@yield('title') – {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('header-styles')

    <x-plausible />
</head>

<body>
<header class="md:fixed w-full bg-white/90 dark:bg-zinc-800/90 backdrop-blur-sm shadow-sm z-40">
    <div class="container max-w-5xl mx-auto md:px-6 antialiased">
        <nav class="flex flex-wrap items-center justify-between md:py-1">
            <x-logo class="w-12 mx-4" />

            <h1 class="grow w-full md:w-auto flex items-center order-3 md:order-none md:-mx-2 py-2 px-4 md:px-0 bg-gray-100 dark:bg-zinc-700 md:dark:bg-transparent md:bg-transparent">
                @empty ($pathInfo?->doc)
                    <a href="/" class="block mx-2 md:text-xl lg:inline-block mr-12 font-black font-mono">\Cornch\Docs::class</a>
                @else
                    <span class="flex lg:inline-flex mx-2 md:text-xl mr-12 font-black font-mono hover:text-gray-600">
                        <a href="{{ url('/') }}" class="hover:text-red-400 transition-colors">\Cornch\Docs</a>
                        <a
                          href="{{ route('docs.show', $pathInfo->toRouteParameters(['page' => $page->loader->docset->index])) }}"
                          class="hover:text-red-400 transition-colors"
                        >\{{ str($pathInfo->doc)->camel()->ucfirst() }}</a>
                        <a href="{{ route('docs.show', $pathInfo->toRouteParameters()) }}" class="hover:text-red-400 transition-colors">\{{ str($pathInfo->page)->camel()->ucfirst() }}</a>
                        @stack('breadcrumb')
                        ::class
                    </span>
                @endempty
            </h1>

            <x-icon-dropdown
                class="mx-4 md:mx-0"
                x-data="{{ Js::from(['current' => $pathInfo->locale->value, 'url' => '', 'locales' => $page->locales()]) }}"
                x-cloak
            >
                <x-slot:icon>
                    <x-heroicon-o-globe-alt class="w-4 h-4 mr-2 text-gray-900 dark:text-zinc-100" />
                </x-slot:icon>

                <x-slot:select
                    x-model="url"
                    x-on:change="window.location.href = url"
                >
                    <template x-for="locale in locales">
                        <option
                            x-bind:value="locale.url"
                            x-bind:selected="locale.code === current"
                            x-text="locale.name"
                        ></option>
                    </template>
                </x-slot:select>

                <x-slot:current class="w-48">{{ $page->locales()[$pathInfo->locale->value]['name'] }}</x-slot:current>
                <x-slot:noscriptList class="w-36">
                    @foreach($page->locales() as $code => ['url' => $url, 'name' => $name])
                        <li class="text-sm my-1 py-1">
                            @if ($code === $pathInfo->locale)
                                {{ $name }}
                            @else
                                <a
                                    href="{{ $url }}"
                                    class="rounded-sm underline hover:no-underline"
                                >
                                    {{ $name }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </x-slot:noscriptList>
            </x-icon-dropdown>
        </nav>
    </div>
</header>

<div
    class="min-h-screen flex flex-col md:flex-row justify-center items-stretch md:pt-14"
    x-data="{show_menu: window.innerWidth > 768}"
    x-on:keyup.m.window="show_menu = !show_menu"
    x-transition
>
    <button
        type="button"
        class="text-center flex md:hidden items-center justify-between px-4 py-2 border-b border-gray-300 dark:border-zinc-700"
        x-show="!show_menu"
        x-on:click="show_menu = true"
        x-cloak
    >
        <span class="inline-flex items-center justify-center">
            <x-heroicon-o-bars-3 class="w-4 h-4 mr-2" />
            {{ __('Show Menu') }}
        </span>

        <span class="inline-flex items-center justify-center">
            <x-heroicon-o-tag class="w-4 h-4 mr-2" />
            {{ $page->version()?->name }}
        </span>
    </button>

    <aside
        class="
            md:fixed md:top-0 md:left-0
            flex flex-col
            md:w-1/5 md:max-h-screen
            md:h-full
            mb-16 md:mb-0
            md:pt-14
            bg-gray-100 dark:bg-zinc-700
            shadow
        "
        x-show="show_menu"
        x-transition
    >
        <template x-teleport="body">
            <button
                type="button" class="fixed top-0 left-0 h-full hidden md:flex items-center justify-center"
                x-show="!show_menu"
                x-on:click="show_menu = true"
                x-transition
            >
                <div class="flex items-center justify-center pl-1 pr-2 py-4 rounded-r bg-gray-200 hover:bg-gray-100 dark:bg-zinc-600 dark:hover:bg-zinc-500 writing-rl transition-colors">
                    {{ __('Show Menu') }}

                    <x-heroicon-o-chevron-double-right class="w-4 h-4 mt-1" />
                </div>
            </button>
        </template>

        <div class="py-4 px-6 border-b border-gray-300 dark:border-zinc-800 flex flex-col items-center justify-center">
            <x-doc-logo class="h-16" :page="$page" />

            <x-icon-dropdown
                size="sm"
                class="flex flex-row justify-end items-stretch"
                x-data="{{ Js::from(['current' => $pathInfo->version, 'url' => '', 'versions' => $page->versions()]) }}"
                x-cloak
            >
                <x-slot:icon>
                    <x-heroicon-o-tag class="w-3 h-3 mr-2 text-gray-900 dark:text-zinc-100" />
                </x-slot:icon>

                <x-slot:select
                    class="bg-gray-200 dark:bg-zinc-700 text-sm"
                    x-model="url"
                    x-on:change="window.location.href = url"
                >
                    <template x-for="version in versions">
                        <option
                            x-bind:value="version.url"
                            x-bind:selected="version.code === current"
                            x-text="version.name"
                        ></option>
                    </template>
                </x-slot:select>

                <x-slot:current class="w-24">{{ $page->version()?->name }}</x-slot:current>
                <x-slot:noscriptList class="w-24 bg-gray-200 dark:bg-zinc-700">
                    @foreach($page->versions() as $version)
                        <li class="text-sm">
                            @if ($version['code'] === $pathInfo->version)
                                {{ $version['name'] }}
                            @else
                                <a
                                    href="{{ $version['url'] }}"
                                    class="rounded-sm underline hover:no-underline"
                                >
                                    {{ $version['name'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </x-slot:noscriptList>
            </x-icon-dropdown>
        </div>

        <x-doc-sidebar class="sidebar grow overflow-y-auto py-4 px-6" :page="$page" />

        <button
            class="
                flex items-center justify-center
                p-2 border-t border-gray-300 dark:border-zinc-800
                bg-gray-200 hover:bg-gray-100 dark:bg-zinc-700 dark:hover:bg-zinc-600
                transition-colors
            "
            x-on:click="show_menu = false"
        >
            <x-heroicon-o-chevron-double-left class="hidden md:inline h-4 w-4 mr-2" />
            <x-heroicon-o-chevron-double-up class="inline md:hidden h-4 w-4 mr-2" />
            {{ __('Hide Menu') }}
        </button>
    </aside>

    <div
        class="w-full md:ml-[20vw] overflow-x-scroll motion-safe:transition-[margin-left]"
        x-bind:class="{ 'md:ml-0!': !show_menu }"
        x-data="{ current: 0, display_zone: 1000 }"
        x-on:scroll.document.throttle.100ms="current = document.documentElement.scrollTop"
    >
        <div
            id="content"
            class="container md:max-w-5xl mx-auto py-12 md:py-6 px-6 md:px-12"
        >
            @yield('content')

            <footer class="md:px-6 mb-16" lang="en">
                <div class="w-full flex py-4">
                    <div class="px-4 flex justify-center items-center">
                        <a href="https://cornch.dev/" target="_blank">
                            <x-logo class="w-12" />
                        </a>
                    </div>
                    <div class="text-gray-600 dark:text-gray-500 text-sm">
                        <p class="mb-4">Code Highlight Provided by <a href="https://torchlight.dev/" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="noopener noreferrer">Torchlight</a></p>

                        <p class="mb-2"><a href="{{ url($pathInfo->locale->value . '/about') }}" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="nofollow noopener">About this Site</a> | <a href="https://github.com/cornch/docs.cornch.dev/blob/main/LICENSE" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="nofollow noopener">License</a> | <a href="https://github.com/cornch/docs.cornch.dev" class="hover:text-gray-500 underline hover:no-underline" target="_blank" rel="nofollow noopener">Source Code</a></p>
                        <p>cornch.dev &copy; {{ date('Y') }} All Rights Reserved.</p>
                    </div>
                </div>
            </footer>

            <template x-teleport="body">
                <button
                    type="button"
                    class="fixed right-12 bottom-12 p-4 rounded-sm bg-white hover:bg-gray-200 dark:bg-neutral-500/60 dark:hover:bg-neutral-400/60 backdrop-blur-sm shadow-sm transition-colors"
                    aria-hidden="true"
                    title="{{ __('Back to Top') }}"
                    x-show="current > display_zone"
                    x-on:click="document.documentElement.scrollTo({ left: 0, top: 0, behavior: 'smooth' });current=0"
                    x-transition
                >
                    <x-heroicon-o-arrow-up class="w-6 h-6" />
                </button>
            </template>
        </div>
    </div>
</div>

@stack('footer-scripts')
</body>
</html>
