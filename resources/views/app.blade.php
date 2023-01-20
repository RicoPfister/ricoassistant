<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {{-- <title inertia>{{ config('app.name', 'Laravel') }}</title> --}}

        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

        <!-- Scripts -->
        @routes
        @vite('resources/js/app.js')
        @inertiaHead
        <title>Rico Assistant</title>

    </head>
    <body class="font-sans antialiased h-full w-full">
        @inertia
    </body>
</html>
