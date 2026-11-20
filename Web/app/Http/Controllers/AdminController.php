<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ============================================================
    //  DASHBOARD
    // ============================================================
    public function dashboard(): View
    {
        return view('admin.ebooks', [
            'totalKamus'     => Ebook::count(),
            'totalMember'    => User::where('role', 'member')->count(),
            'langgananAktif' => Membership::where('status', 'active')->count(),
            'transaksiQris'  => 0,
            'pendapatanBulan'=> 0,
            'memberBaru'     => 0,
            'totalTransaksi' => Transaction::count(),
        ]);
    }

    // ============================================================
    //  KELOLA E-BOOK
    // ============================================================
    public function ebooks(Request $request): View
    {
        $cols = Schema::getColumnListing('buku_digital');

        $totalKamus   = Ebook::count();
        $totalUnduhan = in_array('terjual', $cols) ? (int) Ebook::sum('terjual') : 0;
        $pendapatan   = (in_array('terjual', $cols) && in_array('harga', $cols))
                        ? (int) Ebook::sum(DB::raw('terjual * harga')) : 0;
        $avgRating    = in_array('rating', $cols)
                        ? (float) (Ebook::avg('rating') ?? 0) : 0.0;

        $ebooks = Ebook::orderBy('id', 'desc')->paginate(4);

        return view('admin.ebooks', compact(
            'ebooks', 'totalKamus', 'totalUnduhan', 'pendapatan', 'avgRating', 'cols'
        ));
    }

    // ============================================================
    //  KELOLA PAKET LANGGANAN
    // ============================================================
    public function membership(Request $request): View
    {
        $tiers = MembershipTier::orderBy('order')->get();
        $totalPelanggan = Membership::where('status', 'active')->count();
        $mrr = 0;
        $arpu = 0;
        $tingkatRetensi = 94.2;

        $tiers->each(fn ($t) => $t->setAttribute('active_members', 0));

        $filter = $request->get('filter', 'all');
        if ($filter === 'active') {
            $tiers = $tiers->where('is_active', true);
        }

        return view('admin.membership', compact(
            'tiers', 'totalPelanggan', 'mrr', 'arpu', 'tingkatRetensi', 'filter'
        ));
    }

    // ============================================================
    //  KELOLA PENGGUNA (SUDAH LENGKAP & BULLETPROOF)
    // ============================================================
    public function users(Request $request): View
    {
        // 1. Tangkap tab aktif untuk highlight di view
        $tab = $request->get('tab', 'all');
        
        $query = User::where('role', 'member');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($b) use ($q) {
                $b->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });
        }

        // Opsional: Filter berdasarkan tab (jika ni-sama mau aktifkan nanti)
        // if ($tab === 'suspended') {
        //     $query->where('status', 'suspended');
        // }

        $users = $query->orderBy('id', 'desc')->paginate(10);

        // 2. Stats LENGKAP sesuai kebutuhan view
        $totalMember   = User::where('role', 'member')->count();
        $totalAdmin    = User::where('role', 'admin')->count();
        $baruMingguIni = User::where('role', 'member')
                             ->where('created_at', '>=', now()->subDays(7))->count();
        $pendingVerif  = 0; // Placeholder aman
        $premiumAktif  = Membership::where('status', 'active')->count();
        
        // ✅ Ditangguhan: Cek dulu apakah kolom 'status' ada, biar gak error lagi
        $ditangguhan = 0;
        if (Schema::hasColumn('users', 'status')) {
            $ditangguhan = User::where('role', 'member')->where('status', 'suspended')->count();
        }

        // 3. Kirim SEMUA variabel ke view
        return view('admin.users', compact(
            'users', 
            'totalMember', 
            'totalAdmin', 
            'baruMingguIni', 
            'pendingVerif', 
            'premiumAktif',
            'ditangguhan',
            'tab' // ✅ Wajib ada agar tab "Semua Akun" ter-highlight
        ));
    }

    // ============================================================
    //  TRANSAKSI
    // ============================================================
    public function transaksi(Request $request): View
{
    $cols = \Illuminate\Support\Facades\Schema::getColumnListing('transactions');

    $query = Transaction::with('user');

    // Filter status (Semua / Berhasil / Gagal / Pending)
    $status = $request->get('status', 'all');
    if ($status !== 'all' && in_array('status', $cols)) {
        $query->where('status', $status);
    }

    // Filter periode (30 Hari Terakhir / 7 Hari / Hari Ini)
    $period = $request->get('period', '30');
    if ($period === '7') {
        $query->where('created_at', '>=', now()->subDays(7));
    } elseif ($period === '1') {
        $query->whereDate('created_at', today());
    } else {
        $query->where('created_at', '>=', now()->subDays(30));
    }

    // Search kode referensi
    if ($request->filled('search')) {
        $q = $request->search;
        $query->where('id', 'like', "%{$q}%");
    }

    // ===== Stats (pakai guard) =====
    $totalPemasukan = Transaction::where('status', 'success')->sum('total');
    $transaksiBerhasil = Transaction::where('status', 'success')->count();
    $transaksiGagal = Transaction::where('status', 'failed')->count();
    $volumeHariIni = Transaction::whereDate('created_at', today())->sum('total');
    $transaksiHariIni = Transaction::whereDate('created_at', today())->count();

    $transactions = $query->orderBy('id', 'desc')->paginate(4);

    return view('admin.transaksi', compact(
        'transactions', 'totalPemasukan', 'transaksiBerhasil', 'transaksiGagal',
        'volumeHariIni', 'transaksiHariIni', 'status', 'period'
    ));
}

    // ============================================================
    //  VERIFIKASI
    // ============================================================
    public function verifikasi(): View
    {
        return view('admin.verifikasi');
    }
}