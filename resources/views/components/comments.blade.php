@props(['comments'])

<div class="flex flex-col gap-4">
    <h3 class="text-2xl mb-4">{{ __('Comments') }}</h3>

    @foreach ($comments as $comment)
        <x-comment :comment="$comment" />
    @endforeach
</div>
