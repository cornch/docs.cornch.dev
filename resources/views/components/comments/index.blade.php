@props(['comments', 'commentsCount' => null, 'pathInfo'])

<div class="flex flex-col gap-4">
    <h3 class="text-2xl mb-4">{{ __('Comments') }}</h3>

    <div class="flex flex-col gap-4">
        @forelse ($comments as $comment)
            <x-comments.comment :comment="$comment" />
        @empty
            <div class="mb-4 py-12 rounded border dark:border-zinc-500 text-center text-xl text-zinc-400 dark:text-zinc-600">
                {{ __('No Comments Yet') }}
            </div>
        @endforelse
    </div>

    @if($commentsCount !== null && $commentsCount > $comments->count())
        <div class="flex justify-center items-center">
            <a
                href="{{ route('docs.comments.index', $pathInfo->toRouteParameters()) }}"
                class="
                    inline-block
                    px-4 py-2
                    border border-gray-400
                    dark:border-gray-600
                    rounded
                    bg-white hover:bg-gray-100
                    dark:bg-zinc-800 dark:hover:bg-zinc-700
                    text-blue-500
                    transition-colors
                "
            >
                {{ trans_choice('Show all :count comment|Show all :count comments', $commentsCount, ['count' => $commentsCount]) }}
            </a>
        </div>
    @endif

    <div class="flex justify-end">
        <x-link-button href="{{ route('docs.comments.form', $pathInfo->toRouteParameters()) }}">
            {{ __('Add Comment') }}
        </x-link-button>
    </div>
</div>
