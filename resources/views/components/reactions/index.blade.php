@props(['reactionsCount'])
<div
    x-data="{
        expanded: {{ Js::from(!$reactionsCount->shouldBeCollapsed) }}
    }"
    {{ $attributes }}
>
    <div class="flex -mx-1" x-show="!expanded" x-cloak x-on:click="expanded = true">
        <x-reactions.count>
            <span class="inline-flex">
                @foreach($reactionsCount->topEmojis as $emoji)
                    <span>{{ $emoji }}</span>
                @endforeach
            </span>
            {{ $reactionsCount->total }}
        </x-reactions.count>
    </div>
    <div class="flex -mx-1" x-show="expanded">
        @if($reactionsCount->thumbsUp)
            <x-reactions.count>
                👍 {{ $reactionsCount->thumbsUp }}
            </x-reactions.count>
        @endif

        @if($reactionsCount->thumbsDown)
            <x-reactions.count>
                👎 {{ $reactionsCount->thumbsDown }}
            </x-reactions.count>
        @endif

        @if($reactionsCount->laugh)
            <x-reactions.count>
                😆 {{ $reactionsCount->laugh }}
            </x-reactions.count>
        @endif

        @if($reactionsCount->hooray)
            <x-reactions.count>
                🎉 {{ $reactionsCount->hooray }}
            </x-reactions.count>
        @endif

        @if($reactionsCount->confused)
            <x-reactions.count>
                😕 {{ $reactionsCount->confused }}
            </x-reactions.count>
        @endif

        @if($reactionsCount->heart)
            <x-reactions.count>
                ❤️ {{ $reactionsCount->heart }}
            </x-reactions.count>
        @endif

        @if($reactionsCount->rocket)
            <x-reactions.count>
                🚀 {{ $reactionsCount->rocket }}
            </x-reactions.count>
        @endif

        @if($reactionsCount->eyes)
            <x-reactions.count>
                👀 {{ $reactionsCount->eyes }}
            </x-reactions.count>
        @endif
    </div>
</div>
