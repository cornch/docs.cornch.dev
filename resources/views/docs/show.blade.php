@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale->toBcp47())

@unless(empty($page->styles))
    @push('header-styles')
        <style>{{ $page->styles }}</style>
    @endpush
@endunless

@section('content')
    @if(!$page->version()?->receivesSecurityFixes())
        <x-alert theme="warning">
            <x-slot name="title">
                {{ __('Deprecated version') }}
            </x-slot>

            {{ __('You are viewing a deprecated version of :docName. This version no longer receives bug fixes and security updates. You can switch the version from the sidebar.', ['docName' => $page->loader->getDocName()]) }}<br />
            {{ __('If you are using this version, you should upgrade to the latest version as soon as possible.') }}<br />
            {{ __('The current version of :packageName is :version.', ['packageName' => $page->loader->getPackageName(), 'version' => $page->loader->docset->currentVersion]) }}
        </x-alert>
    @elseif(!$page->version()?->receivesBugFixes())
        <x-alert theme="warning">
            <x-slot name="title">
                {{ __('Deprecated version') }}
            </x-slot>

            {{ __('You are viewing a deprecated version of :docName. This version no longer receives bug fixes. You can switch the version from the sidebar.', ['docName' => $page->loader->getDocName()]) }}<br />
            {{ __('If you are using this version, you should upgrade to the latest version as soon as possible.') }} <br />
            {{ __('The current version of :packageName is :version.', ['packageName' => $page->loader->getPackageName(), 'version' => $page->loader->docset->currentVersion]) }}
        </x-alert>
    @elseif(!$page->version()?->preRelease && !$page->loader->docset->currentVersion !== $page->version()?->key)
        <x-alert theme="warning">
            <x-slot name="title">
                {{ __('This is an old version') }}
            </x-slot>

            {{ __('You are viewing an old version of :docName. You can switch the version from the sidebar.', ['docName' => $page->loader->getDocName()]) }}<br />
            {{ __('If you are using this version, please consider upgrading to the latest version.') }}<br />
            {{ __('The current version of :packageName is :version.', ['packageName' => $page->loader->getPackageName(), 'version' => $page->loader->docset->currentVersion]) }}
        </x-alert>
    @endif
    @if($page->version()?->preRelease)
        <x-alert theme="warning">
            <x-slot name="title">
                {{ __('This is a pre-released version') }}
            </x-slot>

            {{ __('You are viewing a pre-released version of :docName. We do not recommend reading a pre-released version of documentation unless you\'re framework or package developer. You can switch the version from the sidebar.', ['docName' => $page->loader->getPackageName()]) }}
        </x-alert>
    @endif
    @if($page->locale()?->translated && optional($frontMatter)['progress'] < 100)
        <x-alert theme="warning">
            <x-slot name="title">
                {{ __('This is translation is incomplete') }}
            </x-slot>

            {{ __('You are viewing a translated version of :docName. It is possible that some of the content in this page are not translated, or even been wrongly translated. You can switch to the original version by using the language switcher in the header.', ['docName' => $page->loader->getDocName()]) }}
        </x-alert>

        <x-translation-info :info="$frontMatter" :locale="$pathInfo->locale"/>
    @endif

    <article class="content language-php mb-16">
        {{ $page->content }}
    </article>

    @if ($frontMatter !== null && $page->locale()?->translated)
        <x-translation-info :info="$frontMatter" :locale="$pathInfo->locale"/>
    @endif

    <div class="mb-32">
        <x-comments
            :comments="$comments"
            :comments-count="$commentsCount"
            :path-info="$pathInfo"
        />
    </div>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page"/>
    </div>
@endsection
