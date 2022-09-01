<div
    {{
        $attributes->class([
            'flex flex-col gap-y-2',
            'mb-8',
            'px-6 py-4',
            'rounded',
            'border',
            ...$themeStyles(),
        ])
    }}
    role="alert"
>
    @isset($title)
        <strong @class(['font-medium', ...$titleThemeStyles()])>{{ $title }}</strong>
    @endisset
    {{ $slot }}
</div>
