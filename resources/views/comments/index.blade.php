@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale->toBcp47())

@push('breadcrumb')
    <a href="{{ route('docs.comments.index', $pathInfo->toRouteParameters()) }}" class="hover:text-red-400 transition-colors">\Comments</a>
@endpush

@section('content')
    @if(!empty($success))
        <div
            class="
                mb-8
                px-6 py-4
                rounded
                border border-green-700
                text-green-900
                bg-green-100
            "
        >
            {{ $success }}
        </div>
    @endif
    <div class="mb-32">
        <x-comments.index :comments="$comments" :path-info="$pathInfo" />
    </div>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page" />
    </div>
@endsection
