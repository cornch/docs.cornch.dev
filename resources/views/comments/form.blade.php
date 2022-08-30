@extends('layouts.main')

@section('title', $page->title)

@section('lang', $pathInfo->locale->toBcp47())

@section('content')
    <div class="mb-32">
        <form
            class="flex flex-col gap-2 relative"
            @if($captchaProvider !== 'hCaptcha')
                x-data="{ captcha: {{ Js::from($captcha) }} }"
            @endif
        >
            @if($captchaProvider !== 'hCaptcha')
                <input type="hidden" name="captcha_key" value="{{ $captcha['key'] }}" x-bind:value="captcha.key">
            @endif
            <h2 class="flex items-center gap-x-1 text-2xl">
                <x-heroicon-o-chat class="w-4 h-4" />
                {{ __('Add Comment') }}
            </h2>
            <div class="flex flex-col">
                <label
                    for="comment-name"
                    class="after:content-['*'] after:ml-0.5 after:text-red-400"
                >{{ __('Display Name') }} <span class="sr-only">{{ __('(Required)') }}</span></label>
                <input
                    id="comment-name"
                    name="name"
                    type="text"
                    placeholder="{{ __('Display Name') }}"
                    class="
                px-2 py-1
                border border-zinc-600
                rounded
                bg-zinc-800
                text-gray-100
            "
                />
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
                        border border-zinc-600
                        rounded
                        bg-zinc-800
                        text-gray-100
                    "
                />
            </div>
            <div class="flex flex-col">
                <label
                    for="comment-content"
                    class="after:content-['*'] after:ml-0.5 after:text-red-400"
                >{{ __('Content') }}<span class="sr-only">{{ __('(Required)') }}</span></label>
                <textarea
                    id="comment-content"
                    name="content"
                    placeholder="{{ __('Content') }}"
                    class="
                        px-2 py-1
                        border border-zinc-600
                        rounded
                        bg-zinc-800
                        text-gray-100
                    "
                ></textarea>
            </div>
            <div class="flex flex-col">
                @if($captchaProvider === 'hCaptcha')
                    <label
                        for="comment-captcha"
                        class="after:content-['*'] after:ml-0.5 after:text-red-400"
                    >{{ __('Captcha') }}<span class="sr-only">{{ __('(Required)') }}</span></label>
                    <div class="flex gap-4 mb-2">
                        {!! HCaptcha::display() !!}
                    </div>
                    <p class="text-sm text-zinc-500">
                        <a
                            href="{{ route('docs.comments.form', $pathInfo->toRouteParameters()) }}"
                            class="hover:text-zinc-400 underline hover:no-underline transition-colors"
                        >{{ __('Click here to switch to back to old, non-hCaptcha captcha.') }}</a><br />
                    </p>
                @else
                    <label
                        for="comment-captcha"
                        class="after:content-['*'] after:ml-0.5 after:text-red-400"
                    >{{ __('Captcha') }}<span class="sr-only">{{ __('(Required)') }}</span></label>
                    <div class="flex gap-4 mb-2">
                        <a
                            href="{{ route('docs.comments.form', $pathInfo->toRouteParameters()) }}"
                            x-on:click.prevent="fetch({{ Js::from(url('captcha/api')) }}).then((r) => r.json()).then((r) => captcha = r)"
                        >
                            <img src="{{ $captcha['img'] }}" x-bind:src="captcha.img" alt="Captcha" />
                        </a>
                        <input
                            id="comment-captcha"
                            name="captcha"
                            type="text"
                            placeholder="{{ __('Captcha') }}"
                            class="
                                w-full
                                px-2 py-1
                                border border-zinc-600
                                rounded
                                bg-zinc-800
                                text-gray-100
                            "
                        />
                    </div>
                    <p class="text-sm text-zinc-500">
                        {{ __('If you\'re using accessibility technology such as screen reader, or having trouble using the following captcha, you can optionally using "hCaptcha" for this form.') }}<br />
                        <a
                            href="{{ route('docs.comments.form', [...$pathInfo->toRouteParameters(), 'captcha_provider' => 'hCaptcha']) }}"
                            class="hover:text-zinc-400 underline hover:no-underline transition-colors"
                        >{{ __('Click here to switch to hCaptcha.') }}</a><br />
                        {{ __('While hCaptcha providing more accessibility, it\'s a third party service and requires JavaScript.') }}
                    </p>
                @endif
            </div>
            <div class="flex justify-between">
                <p class="text-sm text-zinc-600">
                    {{ __('Markdown supported.') }}<br />
                    {{ __('If you provide a “delete password”, you will be able to delete the comment later using the password.') }}
                </p>
                <button
                    type="submit"
                    class="px-4 py-2 rounded border border-green-800 bg-green-700 hover:bg-green-600 transition-colors"
                >{{ __('Add Comment') }}</button>
            </div>
        </form>
    </div>

    <div class="max-w-5xl mx-auto px-6 mb-16">
        <x-doc-footer :page="$page" />
    </div>
@endsection

@if($captchaProvider === 'hCaptcha')
    @push('footer-scripts')
        {!! HCaptcha::renderJs() !!}
    @endpush
@endif
