@props(['doc'])

<section {{ $attributes }}>
    <div class="md:w-1/4 mx-2">
        {{ $logo }}
    </div>
    <div class="md:w-full mx-2">
        <ul class="list-none">
            @foreach(\App\Documentation\Documentation::get($doc)->versions as $versionCode => $version)
                <li class="mb-4">
                    <p class="mb-2"><b class="font-bold">{{ $version->name }}</b></p>

                    <ul class="flex flex-wrap ml-6 -m-2">
                        @foreach(\App\Documentation\Documentation::get($doc)->locales as $code => $locale)
                            <li class="m-2">
                                <a
                                    href="{{ route('docs.show', ['locale' => $code, 'doc' => $doc, 'version' => $versionCode, 'page' => \App\Documentation\Documentation::get($doc)->index]) }}"
                                    class="px-2 py-1 rounded bg-zinc-200 dark:bg-zinc-900 text-red-500 hover:text-red-400 hover:underline"
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
