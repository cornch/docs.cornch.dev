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
                <x-label for="comment-name" required>
                    {{ __('Display Name') }}
                </x-label>
                <x-input
                    id="comment-name"
                    name="name"
                    placeholder="{{ __('Display Name') }}"
                    value="{{ old('name') }}"
                />
                @error('name')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <div class="flex">
                    <x-label for="comment-delete-password">
                        {{ __('Delete Password') }}
                    </x-label>
                </div>
                <x-input
                    id="comment-delete-password"
                    name="delete_password"
                    placeholder="{{ __('Delete Password') }}"
                    value="{{ old('delete_password') }}"
                />
                @error('delete_password')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex flex-col">
                <x-label for="comment-content" required>
                    {{ __('Content') }}
                </x-label>
                <x-textarea
                    id="comment-content"
                    name="content"
                    placeholder="{{ __('Content') }}"
                    required
                >{{ old('content') }}</x-textarea>
                @error('content')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-between">
                <p class="text-sm text-zinc-600">
                    {{ __('Markdown supported.') }}<br />
                    {{ __('If you provide a “delete password”, you will be able to delete the comment later using the password.') }}
                </p>
                <x-button theme="success" type="submit">{{ __('Add Comment') }}</x-button>
            </div>
        </form>
    </div>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page" />
    </div>
@endsection
