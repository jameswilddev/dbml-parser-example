<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Laravel</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @livewireStyles
    </head>
    <body class="antialiased">
        <livewire:editor />
        <script src="{{ asset('js/app.js') }}"></script>
        @livewireScripts
    </body>
</html>
