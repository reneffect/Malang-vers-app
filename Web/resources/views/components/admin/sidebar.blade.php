@props(['active' => 'kamus'])

<aside class="admin-sidebar">
    {{-- Brand --}}
    <div class="admin-sidebar-brand">
        <span class="admin-sidebar-logo" aria-hidden="true">
            <i class="fas fa-book-open"></i>
        </span>
        <div class="admin-sidebar-brand-text">
            <span class="admin-sidebar-title">MalangVerse</span>
            <span class="admin-sidebar-subtitle">Portal Administrasi</span>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="admin-sidebar-nav">
        <a href="{{ route('admin.ebooks') }}"
           class="admin-sidebar-link {{ $active === 'kamus' ? 'active' : '' }}">
            <i class="fas fa-book-open"></i>
            <span>Kelola Kamus</span>
        </a>

        <a href="{{ route('admin.membership') }}"
           class="admin-sidebar-link {{ $active === 'paket' ? 'active' : '' }}">
            <i class="fas fa-desktop"></i>
            <span>Kelola Paket Langganan</span>
        </a>

        <a href="{{ route('admin.users') }}"
           class="admin-sidebar-link {{ $active === 'pengguna' ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Kelola Pengguna</span>
        </a>

        <a href="{{ route('admin.transaksi') }}"
           class="admin-sidebar-link {{ $active === 'transaksi' ? 'active' : '' }}">
            <i class="fas fa-qrcode"></i>
            <span>Transaksi QRIS</span>
        </a>
    </nav>

    {{-- Logout --}}
    <form method="POST" action="{{ route('admin.logout') }}" class="admin-sidebar-logout">
        @csrf
        <button type="submit" class="admin-sidebar-link danger">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </button>
    </form>
</aside>