@extends('layouts.main')

@section('title', $title)

@section('lang', $locale)

@section('content')
    <x-doc-header class="mb-16" :locale="$locale" :doc="$doc" :version="$version" :page="$page" />

    <div class="container mx-auto px-6 mb-6">
        <div class="flex -mx-2">
            <div class="sidebar w-1/4 mx-2">
                <x-doc-sidebar :locale="$locale" :doc="$doc" :version="$version" :page="$page" />
            </div>

            <div class="content w-3/4 mx-2 language-php">
                {!! $content !!}
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6">
        <x-doc-footer :locale="$locale" :doc="$doc" :version="$version" :page="$page" />
    </div>
@endsection
