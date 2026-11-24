<header class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="flex items-center justify-between px-8 py-4">
        {{-- Search Bar --}}
        <div class="flex-1 max-w-xl">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" 
                       placeholder="Cari kamus atau penulis..."
                       class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm
                              focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 
                              focus:ring-blue-500/10 transition-all">
            </div>
        </div>

        {{-- Profile Admin --}}
        @php($admin = auth()->user())
        <button type="button"
                id="adminProfileTrigger"
                aria-haspopup="dialog"
                aria-controls="adminProfilePanel"
                class="flex items-center gap-3 ml-6 rounded-xl text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
            <div class="text-right">
                <p class="text-sm font-semibold text-gray-900">{{ $admin->name }}</p>
                <p class="text-[11px] text-gray-500">{{ $admin->role_label }}</p>
            </div>
            <div class="w-10 h-10 overflow-hidden rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                @if ($admin->avatar)
                    <img src="{{ asset('storage/'.$admin->avatar) }}" alt="" class="h-full w-full object-cover">
                @else
                    {{ mb_strtoupper(mb_substr($admin->name, 0, 1)) }}
                @endif
            </div>
            <span class="text-gray-400">
                <i class="fas fa-chevron-down text-xs"></i>
            </span>
        </button>
    </div>
</header>

<dialog id="adminProfilePanel"
        aria-labelledby="adminProfileTitle"
        class="fixed inset-y-0 right-0 m-0 h-full max-h-full w-full max-w-md border-0 bg-white p-0 shadow-2xl backdrop:bg-slate-950/40">
    <div class="flex h-full flex-col">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5">
            <h2 id="adminProfileTitle" class="text-base font-bold text-gray-900">
                <i class="fas fa-user-circle mr-2 text-blue-600"></i>Detail Profil Admin
            </h2>
            <form method="dialog">
                <button type="submit" aria-label="Tutup detail profil"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </div>

        <div class="flex-1 space-y-6 overflow-y-auto p-6">
            <section class="border-t-4 border-blue-600 bg-indigo-50/70 px-5 py-6 text-center">
                <div class="mx-auto mb-3 flex h-20 w-20 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-gradient-to-br from-blue-500 to-purple-600 text-2xl font-bold text-white shadow">
                    @if ($admin->avatar)
                        <img src="{{ asset('storage/'.$admin->avatar) }}" alt="" class="h-full w-full object-cover">
                    @else
                        {{ mb_strtoupper(mb_substr($admin->name, 0, 1)) }}
                    @endif
                </div>
                <p class="text-lg font-bold text-gray-900">{{ $admin->name }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ $admin->email }}</p>
                <span class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                    <i class="fas fa-shield-alt"></i>{{ $admin->role_label }}
                </span>
            </section>

            <section>
                <h3 class="mb-3 text-xs font-bold uppercase tracking-wide text-gray-500">Informasi Akun</h3>
                <dl class="divide-y divide-gray-100 rounded-xl border border-gray-200">
                    <div class="flex items-start justify-between gap-4 px-4 py-3">
                        <dt class="text-sm text-gray-500">ID Pengguna</dt>
                        <dd class="text-sm font-semibold text-gray-900">USR-{{ str_pad((string) $admin->id, 4, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 px-4 py-3">
                        <dt class="text-sm text-gray-500">Email</dt>
                        <dd class="break-all text-right text-sm font-semibold text-gray-900">{{ $admin->email }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 px-4 py-3">
                        <dt class="text-sm text-gray-500">Nomor telepon</dt>
                        <dd class="text-right text-sm font-semibold text-gray-900">{{ $admin->phone ?: 'Belum diisi' }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 px-4 py-3">
                        <dt class="text-sm text-gray-500">Bergabung</dt>
                        <dd class="text-right text-sm font-semibold text-gray-900">{{ $admin->created_at?->translatedFormat('d M Y') ?? '—' }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 px-4 py-3">
                        <dt class="text-sm text-gray-500">Status akun</dt>
                        <dd class="inline-flex items-center gap-1.5 text-sm font-semibold text-green-700">
                            <span class="h-2 w-2 rounded-full bg-green-500"></span>Aktif
                        </dd>
                    </div>
                </dl>
            </section>
        </div>

        <div class="border-t border-gray-200 p-5">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-red-700">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </button>
            </form>
        </div>
    </div>
</dialog>

<script>
    document.getElementById('adminProfileTrigger')?.addEventListener('click', () => {
        document.getElementById('adminProfilePanel')?.showModal();
    });

    document.getElementById('adminProfilePanel')?.addEventListener('click', (event) => {
        if (event.target === event.currentTarget) {
            event.currentTarget.close();
        }
    });
</script>