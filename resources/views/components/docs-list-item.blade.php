@props(['doc'])

<section {{ $attributes }}>
    <div class="w-1/4 mx-2">
        {{ $logo }}
    </div>
    <div class="w-full mx-2">
        <ul class="list-none">
            @foreach(config("docs.docsets.{$doc}.versions") as $versionName => $version)
                <li class="mb-4">
                    <p class="mb-2"><b class="font-bold">{{ $versionName }}</b></p>

                    <ul class="flex ml-6 -m-2">
                        @foreach(config("docs.docsets.{$doc}.locales") as $locale => ['name' => $name])
                            <li class="m-2">
                                <a
                                    href="{{ route('docs.show', ['locale' => $locale, 'doc' => 'laravel', 'version' => $version, 'page' => config("docs.docsets.{$doc}.index")]) }}"
                                    class="px-2 py-1 rounded bg-warmGray-200 text-red-500 hover:text-red-400 hover:underline"
                                >{{ $name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</section>
