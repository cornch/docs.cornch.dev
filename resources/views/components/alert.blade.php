<div
    {{
        $attributes->class([
            'flex gap-y-2',
            'mb-8',
            'rounded',
            'border',
            ...$wrapperStyles(),
        ])
    }}
    role="alert"
>
    <div @class($iconWrapperStyles())>
        <x-dynamic-component :component="$icon" class="w-12 h-12" />
    </div>

    <p class="px-6 py-4 rounded-r flex flex-col gap-y-2">
        @isset($title)
            <strong @class(['font-medium', ...$titleThemeStyles()])>{{ $title }}</strong>
        @endisset
        {{ $slot }}
    </p>
</div>
