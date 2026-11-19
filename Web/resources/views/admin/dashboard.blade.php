<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - MalangVerse</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/user/admin/dashboard.css'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="admin-layout">
        {{-- Sidebar --}}
        <x-admin.sidebar active="dashboard" />

        {{-- Main Content --}}
        <main class="admin-main">
            <header class="admin-header">
                <h1 class="admin-header-title">Dashboard Admin</h1>
                <p class="admin-header-subtitle">Selamat datang, {{ auth()->user()->name }} 👋</p>
            </header>

            <div class="admin-content">
                <div class="admin-card">
                    <p>Selamat datang di panel admin MalangVerse!</p>
                </div>

                {{-- Contoh: Statistik Card --}}
                <div class="admin-stats-grid">
                    <div class="admin-stat-card">
                        <i class="fas fa-book"></i>
                        <div>
                            <div class="admin-stat-value">{{ $totalKamus }}</div>
                            <div class="admin-stat-label">Total Kamus</div>
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <i class="fas fa-users"></i>
                        <div>
                            <div class="admin-stat-value">{{ $totalMember }}</div>
                            <div class="admin-stat-label">Total Member</div>
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <i class="fas fa-crown"></i>
                        <div>
                            <div class="admin-stat-value">{{ $langgananAktif }}</div>
                            <div class="admin-stat-label">Langganan Aktif</div>
                        </div>
                    </div>
                    <div class="admin-stat-card">
                        <i class="fas fa-qrcode"></i>
                        <div>
                            <div class="admin-stat-value">{{ $transaksiQris }}</div>
                            <div class="admin-stat-label">Transaksi QRIS</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>