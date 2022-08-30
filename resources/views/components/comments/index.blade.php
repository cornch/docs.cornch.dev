@props(['comments', 'pathInfo'])

<div class="flex flex-col gap-4">
    <h3 class="text-2xl mb-4">{{ __('Comments') }}</h3>

    <div class="flex flex-col gap-4">
        @foreach ($comments as $comment)
            <x-comments.comment :comment="$comment" />
        @endforeach
    </div>

    <div class="flex justify-end">
        <a
            href="{{ route('docs.comments.form', $pathInfo->toRouteParameters()) }}"
            class="inline-block px-4 py-2 rounded border border-green-800 bg-green-700 hover:bg-green-600 transition-colors"
        >
            {{ __('Add Comment') }}
        </a>
    </div>
</div>
