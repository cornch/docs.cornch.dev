<!doctype html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Docs</title>
    <meta name="theme-color" content="00908F">
    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
</head>

<body>
<header class="container mx-auto px-6 mb-12">
    <nav class="flex flex-wrap items-center justify-between lg:justify-start py-10">
        <div class="inline-flex items-center -mx-2 text-md">
            <svg class="w-12 mx-2" alt="\Cornch\Docs::class" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2"><path d="M888.042 528.631l-300 300H520.11v-300h367.933z" fill="#fff"/><path d="M883.214 528.631a1.999 1.999 0 011.414 3.414L595.452 821.221a25.302 25.302 0 01-17.89 7.41H527.11a7 7 0 01-7-7v-286a7 7 0 017-7h356.105zm-295.172 25a6.999 6.999 0 00-7-7H545.11a6.999 6.999 0 00-7 7v250a6.999 6.999 0 007 7h29.328a13.602 13.602 0 0013.605-13.605V553.631zm253.496-3.586a2 2 0 00-1.414-3.414H613.042a6.999 6.999 0 00-7 7v227.082a2 2 0 003.414 1.414l232.082-232.082z" fill="#ff0019"/><path d="M725.62 387.631l-300 300h-67.933v-300H725.62z" fill="#fff"/><path d="M720.792 387.631a1.999 1.999 0 011.414 3.414L433.03 680.221a25.302 25.302 0 01-17.89 7.41h-50.453a7 7 0 01-7-7v-286a7 7 0 017-7h356.105zm-295.172 25a6.999 6.999 0 00-7-7h-35.933a6.999 6.999 0 00-7 7v250a6.999 6.999 0 007 7h29.328a13.602 13.602 0 0013.605-13.605V412.631zm253.496-3.586a2 2 0 00-1.414-3.414H450.62a6.999 6.999 0 00-7 7v227.082a2 2 0 003.414 1.414l232.082-232.082z" fill="#ff0019"/><g><path d="M563.199 246.63l-300 300h-67.933v-300h367.933z" fill="#fff"/><path d="M558.37 246.63a1.999 1.999 0 011.415 3.415L270.609 539.22a25.302 25.302 0 01-17.89 7.41h-50.453a7 7 0 01-7-7v-286a7 7 0 017-7H558.37zm-295.171 25a6.999 6.999 0 00-7-7h-35.933a6.999 6.999 0 00-7 7v250a6.999 6.999 0 007 7h29.328a13.602 13.602 0 0013.605-13.604V271.63zm253.496-3.585a2 2 0 00-1.414-3.414H288.199a6.999 6.999 0 00-7 7v227.082a2 2 0 003.414 1.414l232.082-232.082z" fill="#ff0019"/></g></svg>
            <a href="/" class="block mx-2 text-xl lg:inline-block mr-12 font-black font-mono">\Cornch\Docs::class</a>
        </div>
    </nav>
</header>

<div>
    @yield('content')
    <script src="{{ mix('dist/js/app.js') }}"></script>
</div>
</body>
</html>
