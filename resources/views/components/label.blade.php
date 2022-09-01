@props(['required' => false])

<label
    {{ $attributes->class([
        'flex items-center' => true,
        'after:content-[\'*\'] after:ml-px after:text-red-400' => $required,
    ]) }}
>
    {{ $slot }}
    @if($required)
        <span class="sr-only">{{ __('(Required)') }}</span>
    @endif
</label>
