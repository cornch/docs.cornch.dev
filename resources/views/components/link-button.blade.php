<a
    {{ $attributes->class([
        'inline-block',
        'px-4 py-2',
        'rounded',
        'border border-green-800',
        'bg-green-600 hover:bg-green-500',
        'dark:bg-green-700 dark:hover:bg-green-600',
        'text-white',
        'transition-colors',
    ]) }}
>{{ $slot }}</a>
