@props(['doc'])

<section {{ $attributes }}>
    <div class="md:w-1/4 mx-2">
        {{ $logo }}
    </div>
    <div class="md:w-full mx-2">
        <ul class="list-none">
            @foreach(config("docs.docsets.{$doc}.versions") as $versionName => $version)
                <li class="mb-4">
                    <p class="mb-2"><b class="font-bold">{{ $versionName }}</b></p>

                    <ul class="flex flex-wrap ml-6 -m-2">
                        @foreach(config("docs.docsets.{$doc}.locales") as $locale => ['name' => $name])
                            <li class="m-2">
                                <a
                                    href="{{ route('docs.show', ['locale' => $locale, 'doc' => 'laravel', 'version' => $version, 'page' => config("docs.docsets.{$doc}.index")]) }}"
                                    class="px-2 py-1 rounded bg-zinc-200 dark:bg-zinc-900 text-red-500 hover:text-red-400 hover:underline"
                                >{{ $name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</section>
