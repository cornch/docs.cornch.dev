<div
    {{
        $attributes->class([
            'mb-8',
            'px-6 py-4',
            'rounded',
            'border',
            ...$themeStyles,
        ])
    }}
>
    {{ $slot }}
</div>
