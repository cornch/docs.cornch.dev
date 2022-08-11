@props(['time'])
<span
    x-data="{
      time: dayjs({{ Js::from($time->toIso8601String()) }}),
      relative: null
    }"
    x-init="relative = time.fromNow(); setInterval(() => relative = time.fromNow(), 1000)"
    x-cloak
    x-text="relative"
    x-bind:title="time.local().format('YYYY-MM-DD HH:mm:ss ZZ')"
    {{ $attributes }}
></span>
<noscript>{{ $time->toIso8601String() }}</noscript>
