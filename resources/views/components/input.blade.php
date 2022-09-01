@props(['type' => 'text'])

<input
    {{ $attributes->merge(['type' => $type, 'class' => '
        px-2 py-1
        border
        border-zinc-400 dark:border-zinc-600
        rounded
        bg-white dark:bg-zinc-800
        text-zinc-900 dark:text-gray-100
    ']) }}
/>
