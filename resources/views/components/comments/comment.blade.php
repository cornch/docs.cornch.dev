@props(['comment'])

<div class="rounded" id="comments-{{ $comment->id }}">
    <header
        class="
            flex justify-between gap-2
            px-4 py-1
            border border-zinc-400
            dark:border-zinc-700
            rounded-t
            bg-zinc-100 text-zinc-700
            dark:bg-zinc-700 dark:text-zinc-200
        "
    >
        <div class="flex-grow">
            <strong>
                {{ $comment->name }}
                @if($comment->email)
                    <small
                        class="text-xs"
                        x-data
                        x-text="`(${atob({{ Js::from(base64_encode($comment->email)) }})})`"
                        x-cloak
                    ></small>
                @endif
            </strong>
            <span>@<x-timeago :time="$comment->created_at" /></span>
        </div>
        <div class="flex justify-center items-center">
            <div class="flex items-center gap-1 px-2 border border-zinc-500 dark:border-zinc-200 rounded-full text-xs">
                <x-heroicon-o-tag class="w-3 h-3" />
                {{ $comment->version }}
            </div>
        </div>
        <div class="flex justify-center items-center">
            <x-heroicon-o-trash class="w-4 h-4" />
        </div>
    </header>

    <div class="p-4 border border-t-0 border-zinc-400 dark:border-zinc-700 rounded-b">
        <p class="mb-2">
            {{ $comment->content }}
        </p>

        <x-reactions :reactions-counter="$comment->reactions_counter" />
    </div>
</div>
