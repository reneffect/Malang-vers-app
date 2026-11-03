<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} - MalangVerse</title>

        @vite(['resources/css/guest.css', 'resources/js/app.js'])
    </head>
    <body>
        <x-guest.navbar />

        <main class="page-content">
            <p class="page-eyebrow">MalangVerse</p>
            <h1>{{ $title }}</h1>
            <p>{{ $description }}</p>
        </main>
    </body>
</html>
