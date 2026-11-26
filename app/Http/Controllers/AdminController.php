<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage; // ✅ FIX 1: Tambah import Storage
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    // ============================================================
    //  1. KELOLA E-BOOK
    // ============================================================
    public function ebooks(Request $request): View
    {
        $cols = Schema::getColumnListing('buku_digital'); // Atau 'ebooks' sesuai nama tabel kamu

        $totalKamus = Ebook::count();
        $totalUnduhan = in_array('terjual', $cols) ? (int) Ebook::sum('terjual') : 0;

        // ✅ FIX 3: Samakan nama variabel dengan view (totalPendapatan, totalUlasan)
        $totalPendapatan = (in_array('terjual', $cols) && in_array('harga', $cols))
                            ? (int) Ebook::sum(DB::raw('terjual * harga')) : 0;

        $avgRating = in_array('rating', $cols) ? (float) (Ebook::avg('rating') ?? 0) : 0.0;
        $totalUlasan = in_array('rating', $cols) ? (int) Ebook::whereNotNull('rating')->count() : 0;

        $ebooks = Ebook::orderBy('id', 'desc')->paginate(12);

        return view('admin.ebooks', compact(
            'ebooks', 'totalKamus', 'totalUnduhan', 'totalPendapatan', 'avgRating', 'totalUlasan'
        ));
    }

    public function storeEbook(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'file_pdf' => 'required|file|mimes:pdf|max:153600',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $baseKodeUrl = Str::slug($data['judul']);
        $kodeUrl = $baseKodeUrl;
        $suffix = 2;

        while (Ebook::where('kode_url', $kodeUrl)->exists()) {
            $kodeUrl = $baseKodeUrl.'-'.$suffix;
            $suffix++;
        }

        $data['kode_url'] = $kodeUrl;
        $data['lokasi_berkas'] = $request->file('file_pdf')->store('ebooks/files', 'local');
        if ($request->hasFile('cover_image')) {
            $data['lokasi_sampul'] = $request->file('cover_image')->store('ebooks/covers', 'public');
        }
        $data['sudah_diterbitkan'] = true;
        unset($data['deskripsi'], $data['file_pdf'], $data['cover_image']);

        Ebook::create($data);

        return redirect()->route('admin.ebooks')->with('success', 'E-Book berhasil ditambahkan.');
    }

    public function updateEbook(Request $request, Ebook $ebook)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'file_pdf' => 'nullable|file|mimes:pdf|max:153600',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('file_pdf')) {
            if ($ebook->lokasi_berkas) {
                Storage::disk('local')->delete($ebook->lokasi_berkas);
                Storage::disk('public')->delete($ebook->lokasi_berkas);
            }
            $data['lokasi_berkas'] = $request->file('file_pdf')->store('ebooks/files', 'local');
        }

        if ($request->hasFile('cover_image')) {
            $data['lokasi_sampul'] = $request->file('cover_image')->store('ebooks/covers', 'public');

            if ($ebook->lokasi_sampul) {
                Storage::disk('public')->delete($ebook->lokasi_sampul);
            }
        }

        if ($ebook->judul !== $data['judul']) {
            $baseKodeUrl = Str::slug($data['judul']);
            $kodeUrl = $baseKodeUrl;
            $suffix = 2;

            while (Ebook::where('kode_url', $kodeUrl)->whereKeyNot($ebook->getKey())->exists()) {
                $kodeUrl = $baseKodeUrl.'-'.$suffix;
                $suffix++;
            }

            $data['kode_url'] = $kodeUrl;
        }

        unset($data['deskripsi'], $data['file_pdf'], $data['cover_image']);
        $ebook->update($data);

        return redirect()->route('admin.ebooks')->with('success', 'E-Book berhasil diperbarui.');
    }

    public function deleteEbook(Ebook $ebook)
    {
        if ($ebook->lokasi_berkas) {
            Storage::disk('local')->delete($ebook->lokasi_berkas);
            Storage::disk('public')->delete($ebook->lokasi_berkas);
        }
        if ($ebook->lokasi_sampul) {
            Storage::disk('public')->delete($ebook->lokasi_sampul);
        }
        $ebook->delete();

        return redirect()->route('admin.ebooks')->with('success', 'E-Book berhasil dihapus.');
    }

    // ============================================================
    //  2. KELOLA PAKET LANGGANAN (MEMBERSHIP TIER)
    // ============================================================
    public function membership(Request $request): View
    {
        $cols = Schema::getColumnListing('membership_tiers');

        // Deteksi kolom yang benar-benar ada (anti-crash)
        $colOrder = in_array('sort_order', $cols) ? 'sort_order'
                    : (in_array('order', $cols) ? 'order'
                    : (in_array('price', $cols) ? 'price' : 'id'));
        $colActive = in_array('is_active', $cols) ? 'is_active'
                    : (in_array('active', $cols) ? 'active' : null);
        $colDurasi = in_array('duration_days', $cols) ? 'duration_days'
                    : (in_array('durasi_hari', $cols) ? 'durasi_hari' : null);
        $colFitur = in_array('features', $cols) ? 'features'
                    : (in_array('fitur', $cols) ? 'fitur' : null);

        $tiers = MembershipTier::orderBy($colOrder, 'asc')->get();

        // Cast kolom fitur ke array kalau ada (biar view bisa foreach)
        if ($colFitur) {
            $tiers->each(function ($t) use ($colFitur) {
                $val = $t->{$colFitur};
                if (is_string($val)) {
                    $decoded = json_decode($val, true);
                    $t->setAttribute('features_list', is_array($decoded) ? $decoded : array_filter(array_map('trim', explode("\n", $val))));
                } else {
                    $t->setAttribute('features_list', is_array($val) ? $val : []);
                }
            });
        }

        $totalPelanggan = Schema::hasTable('memberships') && in_array('status', Schema::getColumnListing('memberships'))
            ? Membership::where('status', 'active')->count() : 0;
        $mrr = 0;
        $arpu = 0;
        $tingkatRetensi = 94.2;

        $filter = $request->get('filter', 'all');
        if ($filter === 'active' && $colActive) {
            $tiers = $tiers->where($colActive, true);
        }

        return view('admin.membership', compact(
            'tiers', 'totalPelanggan', 'mrr', 'arpu', 'tingkatRetensi', 'filter', 'cols'
        ));
    }

    public function storeTier(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'required|string',
            'benefits' => 'nullable|string',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        MembershipTier::create($data);

        return redirect()->route('admin.membership')->with('success', 'Tier berhasil ditambahkan.');
    }

    public function updateTier(Request $request, MembershipTier $tier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'required|string',
            'benefits' => 'nullable|string',
            'is_active' => 'nullable',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $tier->update($data);

        return redirect()->route('admin.membership')->with('success', 'Tier berhasil diperbarui.');
    }

    public function deleteTier(MembershipTier $tier)
    {
        $tier->delete();

        return redirect()->route('admin.membership')->with('success', 'Tier berhasil dihapus.');
    }

    public function toggleTier(MembershipTier $tier)
    {
        $tier->update(['is_active' => ! $tier->is_active]);

        return back()->with('success', 'Status tier diperbarui.');
    }

    // ============================================================
    //  3. KELOLA PENGGUNA (USERS)
    // ============================================================
    public function users(Request $request): View
    {
        $tab = $request->get('tab', 'all');
        $query = User::query(); // Hapus where('role', 'member') biar admin juga kelihatan, atau sesuaikan

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($b) use ($q) {
                $b->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users = $query
            ->with('activeMembership.tier')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $selectedUserId = $request->validate([
            'user' => ['nullable', 'integer', 'exists:users,id'],
        ])['user'] ?? null;

        $selectedUser = $selectedUserId
            ? User::with('activeMembership.tier')->findOrFail($selectedUserId)
            : $users->first();

        $totalMember = User::where('role', 'member')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $baruMingguIni = User::where('role', 'member')->where('created_at', '>=', now()->subDays(7))->count();
        $pendingVerif = 0;
        $premiumAktif = Membership::where('status', 'active')->count();

        $ditangguhan = Schema::hasColumn('users', 'status')
            ? User::where('role', 'member')->where('status', 'suspended')->count()
            : 0;

        return view('admin.users', compact(
            'users', 'totalMember', 'totalAdmin', 'baruMingguIni',
            'pendingVerif', 'premiumAktif', 'ditangguhan', 'tab', 'selectedUser'
        ));
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin,member',
            'status' => 'required|in:active,banned',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin,member',
            'status' => 'required|in:active,banned',
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
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah status akun sendiri.');
        }
        $newStatus = ($user->status ?? 'active') === 'active' ? 'banned' : 'active';
        $user->update(['status' => $newStatus]);

        return back()->with('success', 'Status user diperbarui.');
    }

    // ============================================================
    //  4. TRANSAKSI & VERIFIKASI
    // ============================================================
    public function transaksi(Request $request): View
    {
        $cols = Schema::getColumnListing('transactions');

        $colNominal = null;
        foreach (['total', 'total_harga', 'jumlah', 'nominal', 'amount', 'nilai', 'harga', 'grand_total'] as $c) {
            if (in_array($c, $cols)) {
                $colNominal = $c;
                break;
            }
        }

        $status = $request->get('status', 'all');
        $period = $request->get('period', '30');

        $query = Transaction::query();

        if ($status !== 'all' && in_array('status', $cols)) {
            $query->where('status', $status);
        }
        if (in_array('created_at', $cols)) {
            $query->where('created_at', '>=', now()->subDays((int) $period));
        }

        if ($request->filled('search')) {
            $query->where('id', 'like', "%{$request->search}%");
        }

        $transactions = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        $transactions->getCollection()->transform(function ($trx) use ($colNominal) {
            $trx->setAttribute('total', $colNominal ? ($trx->{$colNominal} ?? 0) : 0);

            return $trx;
        });

        $hasStatus = in_array('status', $cols);
        $totalPemasukan = ($colNominal && $hasStatus) ? (int) Transaction::where('status', 'success')->sum($colNominal) : 0;
        $transaksiBerhasil = $hasStatus ? Transaction::where('status', 'success')->count() : 0;
        $transaksiGagal = $hasStatus ? Transaction::whereIn('status', ['failed', 'pending'])->count() : 0;

        $today = now()->startOfDay();
        $transaksiHariIni = Transaction::where('created_at', '>=', $today)->count();
        $volumeHariIni = $colNominal ? (int) Transaction::where('status', 'success')->where('created_at', '>=', $today)->sum($colNominal) : 0;

        return view('admin.transaksi', compact(
            'transactions', 'totalPemasukan', 'transaksiBerhasil', 'transaksiGagal',
            'volumeHariIni', 'transaksiHariIni', 'status', 'period'
        ));
    }

    public function verifikasi(): View
    {
        return view('admin.verifikasi');
    }
}
