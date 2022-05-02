<div
    {{ $attributes->merge(['class' => 'flex group']) }}
>
    <div class="{{ $sizeStyle('icon-wrapper') }} inline-flex justify-center items-center border border-r-0 border-zinc-400 group-hover:border-red-300 text-gray-900 rounded-l-full" aria-hidden="true">
        {{ $icon }}
    </div>
    <div class="relative">
        <select
            {{ $select->attributes->merge(['class' => $sizeStyle('select') . ' w-full border border-l-0 border-zinc-400 group-hover:border-red-300 bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 transition-colors rounded-r-full appearance-none']) }}
        >
            {{ $select }}
        </select>

        <span class="{{ $sizeStyle('chevron-wrapper') }} absolute top-0 h-full flex items-center justify-center">
            <x-heroicon-o-chevron-down class="{{ $sizeStyle('chevron') }} text-gray-900 dark:text-zinc-300" />
        </span>
    </div>
</div>

@if(!empty($noscriptList))
    <noscript>
        <div class="{{ $sizeStyle('noscript') }} border border-zinc-400 rounded-full">
            <details class="relative">
                <summary
                    {{ $current->attributes->merge(['class' => $sizeStyle('summary') . ' flex items-center no-marker']) }}
                >
                    {{ $icon }}
                    <span class="flex-grow">
                        {{ $current }}
                    </span>
                    <x-heroicon-o-chevron-down class="{{ $sizeStyle('chevron') }} text-gray-900" />
                </summary>

                <ul
                    {{ $noscriptList->attributes->merge(['class' => $sizeStyle('noscript-ul') . ' absolute top-full right-0 border border-t-0 border-zinc-400 rounded-b bg-white dark:bg-zinc-800']) }}
                >
                    {{ $noscriptList }}
                </ul>
            </details>
        </div>
    </noscript>
@endif
