<a
    {{ $attributes->class([
        'inline-block',
        'px-4 py-2',
        'rounded',
        'border',
        'transition-colors',
        ...$themeStyles(),
    ]) }}
>{{ $slot }}</a>
