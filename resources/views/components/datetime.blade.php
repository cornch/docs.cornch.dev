@props(['datetime', 'locale'])

<span
    {{ $attributes->merge([
        'x-data' => Js::from(['date' => $datetime->format('c')]),
        'x-html' => 'new Intl.DateTimeFormat(' . Js::from($locale->toBcp47()) . ', { dateStyle: "full", timeStyle: "long" }).format(new Date(date))',
    ]) }}
>
{{ IntlDateFormatter::create($locale->toLaravelLocale(), IntlDateFormatter::LONG, IntlDateFormatter::FULL, 'UTC')->format($datetime) }}
</span>
