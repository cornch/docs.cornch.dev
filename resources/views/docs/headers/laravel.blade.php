<div {{ $attributes->merge(['class' => 'bg-warmGray-200']) }}">
    <div class="container mx-auto px-6 py-12">
        <div class="flex items-center justify-between -mx-2">
            <div class="w-1/3 mx-2">
                <x-logo.laravel class="h-16 -ml-4" />
            </div>
            {{-- use SINGLE QUOTE here for x-data as json_encode is using double quote for string --}}
            <div class="flex justify-end">
                <div class="relative mx-2" x-data='{ locale: "{{ $locale }}", locales: @json($locales) }'>
                    <select
                        class="px-4 pr-8 py-2 border border-red-400 hover:border-red-300 text-gray-900 rounded appearance-none"
                        x-model="locale"
                        x-on:change="window.location.href = locales[locale].url"
                    >
                        @foreach ($locales as $code => ['name' => $name])
                            <option value="{{ $code }}"
                                @if ($code === $locale)
                                    selected
                                @endif
                            >{{ $name }}</option>
                        @endforeach
                    </select>

                    <span class="absolute top-0 right-2 h-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </span>
                </div>
                <div class="relative mx-2" x-data="{ version: '{{ $version }}' }">
                    <select
                        class="px-4 pr-8 py-2 border border-red-400 hover:border-red-300 text-gray-900 rounded appearance-none"
                        x-model="version"
                        x-on:change="window.location.href = '{{ $versionUrl }}'.replace('__version__', version)"
                    >
                        @foreach ($versions as $tag => $v)
                            <option value="{{ $v }}"
                                @if ($v === $version)
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
        </div>
    </div>
</div>
