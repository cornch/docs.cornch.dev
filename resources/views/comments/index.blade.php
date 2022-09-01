@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale->toBcp47())

@push('breadcrumb')
    <a href="{{ route('docs.comments.index', $pathInfo->toRouteParameters()) }}" class="hover:text-red-400 transition-colors">\Comments</a>
@endpush

@section('content')
    @if(!empty($success))
        <x-alert theme="success">{{ $success }}</x-alert>
    @endif
    <div class="mb-32">
        <x-comments.index :comments="$comments" :path-info="$pathInfo" />
    </div>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page" />
    </div>
@endsection
