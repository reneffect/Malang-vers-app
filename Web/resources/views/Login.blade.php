<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - MalangVers</title>
    @vite(['resources/css/login/login.css', 'resources/js/login/login.js'])
</head>
<body class="min-h-screen flex flex-col">

    <div class="flex-1 flex items-left justify-center">
        <a href="{{ route('home') }}" class="brand" aria-label="MalangVerse home">
            <span class="brand-mark">M</span>
            <span class="brand-copy">
                <span class="brand-name">MalangVerse</span>
                <span class="brand-tagline">Preservasi Boso Walikan</span>
            </span>
        <h2>{{ $title }}</h2>

    </div>
    
</body>
</html>