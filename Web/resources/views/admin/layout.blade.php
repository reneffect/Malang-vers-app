<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - MalangVerse')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/user/admin/dashboard.css', 'resources/js/guest.js'])
</head>
<body class="admin-reference-theme bg-gray-100 font-sans antialiased">
    <x-admin.sidebar active="ebooks" />

    <div class="ml-64 min-h-screen flex flex-col">
        <x-admin.topbar />

        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
