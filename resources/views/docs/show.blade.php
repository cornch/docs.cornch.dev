@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale)

@unless(empty($page->styles))
    @push('header-styles')
        <style>{{ $page->styles }}</style>
    @endpush
@endunless

@section('content')
    <x-doc-header class="mb-16" :page="$page" />

    <div class="container max-w-5xl mx-auto px-6 mb-6 overflow-x-hidden">
        <div class="flex flex-col md:flex-row justify-between items-stretch md:-mx-2">
            <div class="sidebar md:w-1/4 mx-6 mb-16 md:mb-0 md:mx-2">
                <x-doc-sidebar :page="$page" />
            </div>

            <div class="content md:w-3/4 mx-6 md:mx-2 language-php">
                {{ $page->content }}
            </div>
        </div>
    </div>

    <div class="container max-w-5xl mx-auto px-6">
        <x-doc-footer :page="$page" />
    </div>
@endsection
