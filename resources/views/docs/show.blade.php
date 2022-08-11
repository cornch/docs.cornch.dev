@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale->toBcp47())

@unless(empty($page->styles))
    @push('header-styles')
        <style>{{ $page->styles }}</style>
    @endpush
@endunless

@section('content')
    <article class="content language-php mb-16">
        {{ $page->content }}
    </article>

    <div class="mb-32">
        <x-comments :comments="$comments" />
    </div>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page" />
    </div>
@endsection
