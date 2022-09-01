@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale->toBcp47())

@unless(empty($page->styles))
    @push('header-styles')
        <style>{{ $page->styles }}</style>
    @endpush
@endunless

@section('content')
    @if($page->version()?->old)
        <x-alert theme="warning">
            <x-slot name="title">
                {{ __('This is an old version') }}
            </x-slot>

            {{ __('You are viewing an old version of :docName. You can switch the version from the sidebar.', ['docName' => $page->loader->getDocName()]) }}
        </x-alert>
    @endif
    @if($page->version()?->preRelease)
        <x-alert theme="warning">
            <x-slot name="title">
                {{ __('This is a pre-released version') }}
            </x-slot>

            {{ __('You are viewing a pre-released version of :docName. We do not recommend reading a pre-released version of documentation unless you\'re framework or package developer. You can switch the version from the sidebar.', ['docName' => $page->loader->getDocName()]) }}
        </x-alert>
    @endif
    @if($page->locale()?->translated)
        <x-alert theme="warning">
            <x-slot name="title">
                {{ __('This is a translated version') }}
            </x-slot>

            {{ __('You are viewing a translated version of :docName. It is possible that some of the content in this page are not translated, or even been wrongly translated. You can switch to the original version by using the language switcher in the header.', ['docName' => $page->loader->getDocName()]) }}
        </x-alert>
    @endif

    <article class="content language-php mb-16">
        {{ $page->content }}
    </article>

    <div class="mb-32">
        <x-comments
            :comments="$comments"
            :comments-count="$commentsCount"
            :path-info="$pathInfo"
        />
    </div>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page" />
    </div>
@endsection
