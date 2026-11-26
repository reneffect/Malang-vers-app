<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    // ============================================================
    //  HELPER
    // ============================================================

    private function membershipsReady(): bool
    {
        return Schema::hasTable('memberships')
            && Schema::hasColumns('memberships', ['user_id', 'membership_tier_id', 'status']);
    }

    private function activeMemberUserIds(?string $tierNameLike = null): array
    {
        if (! $this->membershipsReady()) {
            return [];
        }

        $query = DB::table('memberships as m')
            ->where('m.status', 'active');

        if ($tierNameLike !== null) {
            $query->join('membership_tiers as t', 't.id_membership_tier', '=', 'm.membership_tier_id')
                ->where('t.name', 'like', "%{$tierNameLike}%");
        }

        return $query->distinct()->pluck('m.user_id')->all();
    }

    private function activeTierNames(): array
    {
        if (! $this->membershipsReady()) {
            return [];
        }

        return DB::table('memberships as m')
            ->join('membership_tiers as t', 't.id_membership_tier', '=', 'm.membership_tier_id')
            ->where('m.status', 'active')
            ->orderByDesc('m.started_at')
            ->get(['m.user_id', 't.name'])
            ->unique('user_id')
            ->pluck('name', 'user_id')
            ->all();
    }

    private function generateUniqueSlug(string $table, string $column, string $value, ?int $ignoreId = null, string $ignoreKey = 'id'): string
    {
        $base = Str::slug($value) ?: 'item';
        $slug = $base;
        $suffix = 2;

        while (
            DB::table($table)
                ->where($column, $slug)
                ->when($ignoreId, fn ($q) => $q->where($ignoreKey, '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    // ============================================================
    //  1. KELOLA E-BOOK  (tabel: buku_digital)
    // ============================================================

    public function ebooks(Request $request): View
    {
        // 1. Total Kamus Aktif (hanya menghitung yang sudah diterbitkan)
        $totalKamus = Ebook::where('sudah_diterbitkan', true)->count();

        // 2. Total Unduhan/Terjual (menggunakan kolom 'terjual' dari model Ebook)
        $totalUnduhan = (int) Ebook::sum('terjual');

        // 3. Total Pendapatan (menghitung harga * terjual, COALESCE mencegah error null)
        $totalPendapatan = (int) Ebook::selectRaw('COALESCE(SUM(terjual * harga), 0) as total')->value('total');

        // Catatan: Tabel buku_digital belum punya kolom rating/ulasan
        $avgRating = 0.0;
        $totalUlasan = 0;

        $ebooks = Ebook::orderBy('id', 'desc')->paginate(12); // Bisa diubah ke 4 sesuai preferensi awal

        return view('admin.ebooks', compact(
            'ebooks', 'totalKamus', 'totalUnduhan', 'totalPendapatan', 'avgRating', 'totalUlasan'
        ));
    }

    public function storeEbook(Request $request)
    {
        $data = $request->validate([
            'judul'          => 'required|string|max:200',
            'penulis'        => 'required|string|max:150',
            'kategori'       => 'required|string|max:100',
            'harga'          => 'required|numeric|min:0|max:9999999999.99',
            'jumlah_halaman' => 'nullable|integer|min:0',
            'file_pdf'       => 'required|file|mimes:pdf|max:153600',
            'cover_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'harga.max' => 'Harga maksimal Rp 9.999.999.999.',
        ]);

        $kodeUrl = $this->generateUniqueSlug('buku_digital', 'kode_url', $data['judul']);

        $payload = [
            'judul'             => $data['judul'],
            'penulis'           => $data['penulis'],
            'kategori'          => $data['kategori'],
            'harga'             => $data['harga'],
            'jumlah_halaman'    => $data['jumlah_halaman'] ?? null,
            'kode_url'          => $kodeUrl,
            'lokasi_berkas'     => $request->file('file_pdf')->store('ebooks/files', 'public'),
            'sudah_diterbitkan' => true,
        ];

        if ($request->hasFile('cover_image')) {
            $payload['lokasi_sampul'] = $request->file('cover_image')->store('ebooks/covers', 'public');
        }

        Ebook::create($payload);

        return redirect()->route('admin.ebooks')->with('success', 'E-Book berhasil ditambahkan.');
    }

    public function updateEbook(Request $request, Ebook $ebook)
    {
        $data = $request->validate([
            'judul'          => 'required|string|max:200',
            'penulis'        => 'required|string|max:150',
            'kategori'       => 'required|string|max:100',
            'harga'          => 'required|numeric|min:0|max:9999999999.99',
            'jumlah_halaman' => 'nullable|integer|min:0',
            'file_pdf'       => 'nullable|file|mimes:pdf|max:153600',
            'cover_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'harga.max' => 'Harga maksimal Rp 9.999.999.999.',
        ]);

        if ($request->hasFile('file_pdf')) {
            if ($ebook->lokasi_berkas) {
                Storage::disk('public')->delete($ebook->lokasi_berkas);
            }
            $data['lokasi_berkas'] = $request->file('file_pdf')->store('ebooks/files', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($ebook->lokasi_sampul) {
                Storage::disk('public')->delete($ebook->lokasi_sampul);
            }
            $data['lokasi_sampul'] = $request->file('cover_image')->store('ebooks/covers', 'public');
        }

        if ($ebook->judul !== $data['judul']) {
            $data['kode_url'] = $this->generateUniqueSlug('buku_digital', 'kode_url', $data['judul'], $ebook->getKey(), 'id');
        }

        unset($data['file_pdf'], $data['cover_image']);
        $ebook->update($data);

        return redirect()->route('admin.ebooks')->with('success', 'E-Book berhasil diperbarui.');
    }

    public function deleteEbook(Ebook $ebook)
    {
        if ($ebook->lokasi_berkas) {
            Storage::disk('public')->delete($ebook->lokasi_berkas);
        }
        if ($ebook->lokasi_sampul) {
            Storage::disk('public')->delete($ebook->lokasi_sampul);
        }

        $ebook->delete();

        return redirect()->route('admin.ebooks')->with('success', 'E-Book berhasil dihapus.');
    }

    // ============================================================
    //  2. KELOLA PENGGUNA  (tabel: users)
    // ============================================================

    public function users(Request $request): View
    {
        $tab = $request->get('tab', 'all');

        $query = User::where('role', 'member');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($b) use ($q) {
                $b->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($tab === 'gratis') {
            $query->whereNotIn('id', $this->activeMemberUserIds());
        } elseif ($tab === 'standar') {
            $query->whereIn('id', $this->activeMemberUserIds('standar'));
        } elseif ($tab === 'premium') {
            $query->whereIn('id', $this->activeMemberUserIds('premium'));
        }

        $users = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $activeTiers = $this->activeTierNames();

        $selectedUser = null;
        if ($request->filled('user')) {
            $selectedUser = User::where('role', 'member')->find($request->query('user'));
        }
        $selectedUser ??= $users->first();

        $riwayat = collect();
        if ($selectedUser && $this->membershipsReady()) {
            $riwayat = DB::table('memberships as m')
                ->leftJoin('membership_tiers as t', 't.id_membership_tier', '=', 'm.membership_tier_id')
                ->where('m.user_id', $selectedUser->id)
                ->orderByDesc('m.started_at')
                ->limit(5)
                ->get(['m.status', 'm.started_at', 'm.ends_at', 't.name as tier_name']);
        }

        $totalMember   = User::where('role', 'member')->count();
        $totalAdmin    = User::where('role', 'admin')->count();
        $baruMingguIni = User::where('role', 'member')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $premiumAktif  = count($this->activeMemberUserIds());
        $pendingVerif  = 0;
        $ditangguhan   = 0; 

        return view('admin.users', compact(
            'users', 'totalMember', 'totalAdmin', 'baruMingguIni',
            'pendingVerif', 'premiumAktif', 'ditangguhan', 'tab',
            'selectedUser', 'activeTiers', 'riwayat'
        ));
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:users,email',
            'phone'    => 'nullable|string|max:30',
            'role'     => 'required|in:admin,member',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:users,email,'.$user->id,
            'phone'    => 'nullable|string|max:30',
            'role'     => 'required|in:admin,member',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    public function toggleUser(User $user)
    {
        return back()->with('error', 'Fitur tangguhkan belum tersedia, kolom status belum ada di tabel users.');
    }

    // ============================================================
    //  3. TRANSAKSI  (tabel: transactions)
    // ============================================================

    public function transaksi(Request $request): View
    {
        $status = $request->get('status', 'all');
        $period = (int) $request->get('period', 30);
        $search = trim((string) $request->get('search', ''));

        $query = Transaction::with('user')
            ->where('created_at', '>=', now()->subDays($period));

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where('transaction_code', 'like', "%{$search}%");
        }

        $transactions = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $today = now()->startOfDay();

        $totalPemasukan    = (int) Transaction::where('status', 'paid')->sum('total_amount');
        $transaksiBerhasil = Transaction::where('status', 'paid')->count();
        $transaksiGagal    = Transaction::whereIn('status', ['pending', 'cancelled', 'expired'])->count();
        $transaksiHariIni  = Transaction::where('created_at', '>=', $today)->count();
        $volumeHariIni     = (int) Transaction::where('status', 'paid')
            ->where('created_at', '>=', $today)
            ->sum('total_amount');

        return view('admin.transaksi', compact(
            'transactions', 'totalPemasukan', 'transaksiBerhasil', 'transaksiGagal',
            'volumeHariIni', 'transaksiHariIni', 'status', 'period'
        ));
    }

    // ============================================================
    //  4. VERIFIKASI
    // ============================================================

    public function verifikasi(): View
    {
        return view('admin.verifikasi');
    }
}