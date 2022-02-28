<?php /** @var \App\Documentation\Models\PathInfo $pathInfo */ ?>

<div {{ $attributes->merge(['class' => 'bg-zinc-200 dark:bg-zinc-700']) }}">
    <div class="container max-w-5xl mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row items-center justify-between -m-2">
            <div class="md:w-1/3 m-2">
                <x-logo.laravel class="h-16 -ml-4" />
            </div>
            {{-- use SINGLE QUOTE here for x-data as json_encode is using double quote for string --}}
            <div class="flex flex-row justify-end items-stretch"
                 x-data='{ locale: "{{ $pathInfo->locale }}", locales: @json($locales), version: "{{ $pathInfo->version }}" }'
                 x-cloak
            >
                <div class="relative m-2">
                    <select
                        class="w-full px-4 pr-8 py-2 border border-zinc-400 hover:border-red-300 text-gray-900 bg-zinc-200 transition-colors rounded appearance-none"
                        x-model="locale"
                        x-on:change="window.location.href = locales[locale].url"
                    >
                        @foreach ($locales as $code => ['name' => $name])
                            <option value="{{ $code }}"
                                @if ($code === $pathInfo->locale)
                                    selected
                                @endif
                            >{{ $name }}</option>
                        @endforeach
                    </select>

                    <span class="absolute top-0 right-2 h-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </div>
                <div class="relative m-2">
                    <select
                        class="w-full px-4 pr-8 py-2 border border-zinc-400 hover:border-red-300 text-gray-900 bg-zinc-200 transition-colors rounded appearance-none"
                        x-model="version"
                        x-on:change="window.location.href = '{{ $versionUrl }}'.replace('__version__', version)"
                    >
                        @foreach ($versions as $tag => $v)
                            <option value="{{ $v }}"
                                @if ($v === $pathInfo->version)
                                    selected
                                @endif
                            >{{ $tag }}</option>
                        @endforeach
                    </select>

                    <span class="absolute top-0 right-2 h-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </div>
            </div>

            <noscript>
                <div class="flex justify-end -mx-2">
                    <div class="mx-2 px-2 py-1 border border-zinc-700 rounded">
                        <details class="relative">
                            <summary class="flex items-center gap-2">{{ $locales[$pathInfo->locale]['name'] }}</summary>

                            <ul class="absolute top-full mt-1 px-2 py-1 border border-zinc-700 border-t-0 rounded-b">
                                @foreach($locales as $code => ['url' => $url, 'name' => $name])
                                    <li class="text-sm">
                                        @if ($code === $pathInfo->locale)
                                            {{ $name }}
                                        @else
                                            <a href="{{ $url }}"
                                               class="rounded underline hover:no-underline"
                                            >
                                                {{ $name }}
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </details>
                    </div>

                    <div class="mx-2 px-2 py-1 border border-zinc-700 rounded">
                        <details class="relative">
                            <summary class="flex items-center gap-2">{{ $pathInfo->version }}</summary>

                            <ul class="absolute top-full mt-1 px-2 py-1 border border-zinc-700 border-t-0 rounded-b">
                                @foreach($versions as $name => $code)
                                    <li class="text-sm">
                                        @if ($code === $pathInfo->version)
                                            {{ $name }}
                                        @else
                                            <a href="{{ route('docs.show', [...$pathInfo->toRouteParameters(), 'version' => $code]) }}"
                                               class="rounded underline hover:no-underline"
                                            >
                                                {{ $name }}
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </details>
                    </div>
                </div>
            </noscript>
        </div>
    </div>

    <div class="md:hidden h-full py-4 border-b bg-white h-full">
        <div class="container px-6">
            <a href="{{ url($pathInfo->locale . '/laravel/' . $pathInfo->version . '/documentation')  }}" class="flex items-center gap-2">
                <x-heroicon-o-menu class="w-4 h-4" aria-hidden="true" />
                {{ __('Show Menu') }}
            </a>
        </div>
    </div>
</div>
