<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Laravel DevTools</title>
    
    @if(config('laraveldevtools.dev'))
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="http://localhost:5173/resources/js/app.js" type="module"></script>
    @else
        <link rel="stylesheet" href="{{ asset('vendor/laraveldevtools/app.css') }}">
        <script src="{{ asset('vendor/laraveldevtools/app.js') }}"></script>
    @endif
    @livewireStyles
</head>
<body class="overflow-hidden w-screen h-screen">

    {{ $slot }}
    @livewireScripts
</body>
</html>