@props(['type' => 'button'])

<button
    {{
        $attributes
            ->merge(['type' => $type])
            ->class([
                'inline-block',
                'px-4 py-2',
                'rounded-sm',
                'border',
                'transition-colors',
                ...$themeStyles(),
            ])
    }}
>{{ $slot }}</button>
