@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale->toBcp47())

@push('breadcrumb')
    <a href="{{ route('docs.comments.form', $pathInfo->toRouteParameters()) }}" class="hover:text-red-400 transition-colors">\CommentForm</a>
@endpush

@section('content')
    <div class="mb-32">
        <form
            action="{{ route('docs.comments.store', $pathInfo->toRouteParameters()) }}"
            method="post"
            class="flex flex-col gap-2 relative"
        >
            @csrf
            <x-honeypot />
            <h2 class="flex items-center gap-x-1 text-2xl">
                <x-heroicon-o-chat class="w-4 h-4" />
                {{ __('Add Comment') }}
            </h2>
            <div class="flex flex-col">
                <label
                    for="comment-name"
                    class="after:content-['*'] after:ml-px after:text-red-400"
                >{{ __('Display Name') }}<span class="sr-only">{{ __('(Required)') }}</span></label>
                <input
                    id="comment-name"
                    name="name"
                    type="text"
                    placeholder="{{ __('Display Name') }}"
                    class="
                        px-2 py-1
                        border
                        border-zinc-400 dark:border-zinc-600
                        rounded
                        bg-white dark:bg-zinc-800
                        text-zinc-900 dark:text-gray-100
                    "
                    value="{{ old('name') }}"
                />
                @error('name')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <div class="flex">
                    <label
                        for="comment-delete-password"
                    >{{ __('Delete Password') }}</label>
                </div>
                <input
                    id="comment-delete-password"
                    name="delete_password"
                    type="password"
                    placeholder="{{ __('Delete Password') }}"
                    class="
                        px-2 py-1
                        border
                        border-zinc-400 dark:border-zinc-600
                        rounded
                        bg-white dark:bg-zinc-800
                        text-zinc-900 dark:text-gray-100
                    "
                    value="{{ old('delete_password') }}"
                />
                @error('delete_password')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <label
                    for="comment-content"
                    class="after:content-['*'] after:ml-px after:text-red-400"
                >{{ __('Content') }}<span class="sr-only">{{ __('(Required)') }}</span></label>
                <textarea
                    id="comment-content"
                    name="content"
                    placeholder="{{ __('Content') }}"
                    class="
                        px-2 py-1
                        border
                        border-zinc-400 dark:border-zinc-600
                        rounded
                        bg-white dark:bg-zinc-800
                        text-zinc-900 dark:text-gray-100
                    "
                    required
                >{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-between">
                <p class="text-sm text-zinc-600">
                    {{ __('Markdown supported.') }}<br />
                    {{ __('If you provide a “delete password”, you will be able to delete the comment later using the password.') }}
                </p>
                <button
                    type="submit"
                    class="inline-block px-4 py-2 rounded border border-green-800 bg-green-600 hover:bg-green-500 dark:bg-green-700 dark:hover:bg-green-600 text-white transition-colors"
                >{{ __('Add Comment') }}</button>
            </div>
        </form>
    </div>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page" />
    </div>
@endsection
