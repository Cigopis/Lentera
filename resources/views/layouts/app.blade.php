<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Lentera') }}</title>

    {{-- Paksa background terang sejak awal, sebelum CSS/JS load --}}
    <style>
        html, body { background-color: #f0f9ff !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body >


    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />

</body>
</html>