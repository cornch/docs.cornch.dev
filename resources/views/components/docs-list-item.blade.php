@props(['doc'])

<section {{ $attributes }}>
    <div class="md:w-1/4 mx-2">
        {{ $logo }}
    </div>
    <div class="md:w-full mx-2">
        <ul class="list-none">
            @foreach(\App\Documentation\Documentation::get($doc)->versions as $versionCode => $version)
                <li
                    class="mb-4"
                    @if($version->preRelease)
                        x-show="showPreRelease"
                    @elseif($version->deprecated())
                        x-show="showDeprecated"
                    @endif
                >
                    <p class="mb-2 space-x-2">
                        <b class="font-bold">{{ $version->name }}</b>
                        @if($version->preRelease)
                            <span class="rounded-full text-xs bg-blue-200 text-blue-800 py-px px-2">
                                {{ __('Pre-Release') }}
                            </span>
                        @elseif($version->deprecated())
                            <span class="rounded-full text-xs bg-yellow-200 text-yellow-800 py-px px-2">
                                {{ __('Deprecated') }}
                            </span>
                        @endif
                    </p>

                    <ul class="flex flex-wrap ml-6 -m-2">
                        @foreach(\App\Documentation\Documentation::get($doc)->locales as $code => $locale)
                            <li class="m-2">
                                <a
                                    href="{{ route('docs.show', ['locale' => $code, 'doc' => $doc, 'version' => $versionCode, 'page' => \App\Documentation\Documentation::get($doc)->index]) }}"
                                    class="px-2 py-1 rounded-sm bg-zinc-200 dark:bg-zinc-900 text-red-500 hover:text-red-400 hover:underline"
                                    lang="{{ \App\Enums\Locale::from($code)->toBcp47() }}"
                                >{{ $locale->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</section>
