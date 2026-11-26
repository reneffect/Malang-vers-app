{{-- ✅ MODAL KELOLA DATA PENGGUNA (MANAGE USER) --}}
<div id="modalUser" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto animate-in fade-in zoom-in duration-200">
        
        {{-- Header Modal --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-900" id="modalUserTitle">Kelola Data Pengguna</h3>
            <button onclick="toggleModal('modalUser')" class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-500 flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Form Update User --}}
        <form action="{{ route('admin.users.update', $user->id ?? 'ID_USER') }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Informasi Dasar (Read-only / Info) --}}
            <div class="bg-gray-50 rounded-xl p-4 space-y-3 border border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">ID Pengguna</span>
                    <span class="text-xs font-bold text-blue-600">USER-MV-0042</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Nama Lengkap</span>
                    <span class="text-xs font-semibold text-gray-900">Budi Santoso</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Alamat Email</span>
                    <span class="text-xs font-semibold text-gray-900">budi.santoso@email.com</span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-200 pt-3 mt-3">
                    <span class="text-xs text-gray-500">Bergabung Sejak</span>
                    <span class="text-xs font-medium text-gray-700">24 Oktober 2023</span>
                </div>
            </div>

            {{-- Field yang Bisa Diubah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Role / Peran</label>
                    <select name="role" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value="member">Member Biasa</option>
                        <option value="premium">Member Premium</option>
                        <option value="moderator">Moderator</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-700">Status Akun</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value="active">Aktif</option>
                        <option value="suspended">Ditangguhkan (Suspended)</option>
                        <option value="banned">Diblokir (Banned)</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Paket Langganan Saat Ini</label>
                <select name="subscription_tier" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    <option value="free">Gratis (Free Tier)</option>
                    <option value="basic">Paket Dasar (Basic)</option>
                    <option value="pro">Paket Profesional (Pro)</option>
                </select>
            </div>

            {{-- Opsi Reset Password --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 space-y-3">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="reset_password" id="reset_password" value="1" class="w-4 h-4 text-amber-600 border-amber-300 rounded focus:ring-amber-500">
                    <label for="reset_password" class="text-sm font-semibold text-amber-800">Paksa Reset Password Pengguna</label>
                </div>
                <p class="text-[11px] text-amber-700 leading-relaxed">
                    <i class="fas fa-info-circle mr-1"></i> 
                    Jika dicentang, sistem akan mengirimkan email berisi tautan reset password ke alamat email pengguna tersebut.
                </p>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-700">Catatan Admin (Opsional)</label>
                <textarea name="admin_notes" rows="2" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all" placeholder="Contoh: Akun dibekukan sementara karena pelanggaran ToS..."></textarea>
            </div>

            {{-- Footer Modal --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="toggleModal('modalUser')" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/25 transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>