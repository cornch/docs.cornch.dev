@props(['reactionsCounter'])
<div
    x-data="{
        expanded: {{ Js::from(!$reactionsCounter->shouldBeCollapsed) }}
    }"
    {{ $attributes }}
>
    <div class="flex -mx-1" x-show="!expanded" x-cloak x-on:click="expanded = true">
        <x-reactions.count>
            <span class="inline-flex">
                @foreach($reactionsCounter->topEmojis as $emoji)
                    <span>{{ $emoji }}</span>
                @endforeach
            </span>
            {{ $reactionsCounter->total }}
        </x-reactions.count>
    </div>
    <div class="flex -mx-1" x-show="expanded">
        @if($reactionsCounter->thumbsUp)
            <x-reactions.count>
                👍 {{ $reactionsCounter->thumbsUp }}
            </x-reactions.count>
        @endif

        @if($reactionsCounter->thumbsDown)
            <x-reactions.count>
                👎 {{ $reactionsCounter->thumbsDown }}
            </x-reactions.count>
        @endif

        @if($reactionsCounter->laugh)
            <x-reactions.count>
                😆 {{ $reactionsCounter->laugh }}
            </x-reactions.count>
        @endif

        @if($reactionsCounter->hooray)
            <x-reactions.count>
                🎉 {{ $reactionsCounter->hooray }}
            </x-reactions.count>
        @endif

        @if($reactionsCounter->confused)
            <x-reactions.count>
                😕 {{ $reactionsCounter->confused }}
            </x-reactions.count>
        @endif

        @if($reactionsCounter->heart)
            <x-reactions.count>
                ❤️ {{ $reactionsCounter->heart }}
            </x-reactions.count>
        @endif

        @if($reactionsCounter->rocket)
            <x-reactions.count>
                🚀 {{ $reactionsCounter->rocket }}
            </x-reactions.count>
        @endif

        @if($reactionsCounter->eyes)
            <x-reactions.count>
                👀 {{ $reactionsCounter->eyes }}
            </x-reactions.count>
        @endif
    </div>
</div>
