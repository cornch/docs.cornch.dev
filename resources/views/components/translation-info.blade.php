@props(['info', 'locale'])

<div class="mb-16 px-6 py-4 border dark:border-zinc-500 rounded flex flex-col md:flex-row items-start md:items-center gap-8">
    <dl class="flex-grow flex flex-col gap-y-2">
        <div class="w-full flex flex-col gap-y-1">
            <dt class="sr-only">{{ __('Translation Progress') }}</dt>
            <dd class="w-full">
                <span class="text-xs">
                    {{ $info['progress'] }}% {{ __('Translated') }}
                </span>
                <div
                    class="rounded-full h-2 w-full bg-white bg-gray-200 dark:bg-zinc-500"
                    aria-hidden="true"
                >
                    <div
                        @class([
                            'rounded-full h-2',
                            $info['progress'] === 100 ? 'bg-green-500 dark:bg-green-600' : 'bg-amber-500 dark:bg-amber-600',
                        ])
                        style="width: {{ $info['progress'] }}%"
                    ></div>
                </div>
            </dd>
        </div>

        <div class="flex gap-1">
            <dt class="text-zinc-500 flex-shrink-0">{{ __('Updated at') }}</dt>
            <dd class="text-zinc-400">
                <x-datetime :datetime="Date::parse($info['updatedAt'])" :locale="$locale" />
            </dd>
        </div>
        <div class="flex gap-1">
            <dt class="text-zinc-500 flex-shrink-0">{{ __('Translated by') }}</dt>
            <dd>
                <ul role="list" class="flex text-zinc-400 gap-x-1">
                    @foreach(collect($info['contributors'])->pluck('name')->sort() as $translator)
                        <li
                            class="
                                first:before:!content-none
                                before:content-[attr(data-separator)]
                                last:before:content-[attr(data-last-separator)]
                            "
                            data-separator="{{ __(', ') }}"
                            data-last-separator="{{ __(', and ') }}"
                        >
                            {{ $translator }}
                        </li>
                    @endforeach
                </ul>
            </dd>
        </div>
    </dl>

    <x-link-button href="{{ $info['crowdinUrl'] }}" target="_blank" rel="noreferrer noopener nofollow" class="flex-shrink-0">
        {{ __('Help Us Translate This Page') }}
    </x-link-button>
</div>
