@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale)

@unless(empty($page->styles))
    @push('header-styles')
        <style>{{ $page->styles }}</style>
    @endpush
@endunless

@section('content')
    <article class="content language-php">
        {{ $page->content }}
    </article>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page" />
    </div>
@endsection
