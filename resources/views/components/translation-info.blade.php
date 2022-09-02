@props(['info'])

<div class="mb-16 px-6 py-4 border dark:border-zinc-500 rounded flex items-center gap-8">
    <dl class="flex-grow flex flex-col gap-y-2">
        <div class="w-full flex flex-col gap-y-1">
            <dt class="sr-only">{{ __('Translation Progress') }}</dt>
            <dd class="w-full">
                <span class="text-xs">
                    {{ $info['progress'] }}% {{ __('Translated') }}
                </span>
                <div class="rounded-full h-2 w-full bg-white dark:bg-zinc-500" aria-hidden="true">
                    <div class="rounded-full h-2 bg-amber-500" style="width: {{ $info['progress'] }}%"></div>
                </div>
            </dd>
        </div>

        <div class="flex gap-1">
            <dt class="text-zinc-500">{{ __('Translated by') }}</dt>
            <dd>
                <ul role="list" class="flex text-zinc-400">
                    @foreach(collect($info['contributors'])->pluck('name')->sort() as $translator)
                        <li
                            class="
                                first:before:!content-none
                                before:content-['{{ __(',_') }}']
                                last:before:content-['{{ __(',_and_') }}']
                            "
                        >
                            {{ $translator }}
                        </li>
                    @endforeach
                </ul>
            </dd>
        </div>
    </dl>

    <x-link-button href="{{ $info['crowdinUrl'] }}" target="_blank" rel="noreferrer noopener nofollow">
        {{ __('Help Us Translate This Page') }}
    </x-link-button>
</div>
