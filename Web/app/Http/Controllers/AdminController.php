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
        $jumlahUlasan = in_array('rating', $cols)
                        ? (int) Ebook::whereNotNull('rating')->count() : 0;

        $ebooks = Ebook::orderBy('id', 'desc')->paginate(4);

        return view('admin.ebooks', compact(
            'ebooks', 'totalKamus', 'totalUnduhan', 'pendapatan', 'avgRating', 'jumlahUlasan', 'cols'
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
    //  KELOLA PENGGUNA
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

        $users = $query->orderBy('id', 'desc')->paginate(10);

        $totalMember   = User::where('role', 'member')->count();
        $totalAdmin    = User::where('role', 'admin')->count();
        $baruMingguIni = User::where('role', 'member')
                             ->where('created_at', '>=', now()->subDays(7))->count();
        $pendingVerif  = 0;
        $premiumAktif  = Membership::where('status', 'active')->count();

        $ditangguhan = 0;
        if (Schema::hasColumn('users', 'status')) {
            $ditangguhan = User::where('role', 'member')->where('status', 'suspended')->count();
        }

        return view('admin.users', compact(
            'users', 'totalMember', 'totalAdmin', 'baruMingguIni',
            'pendingVerif', 'premiumAktif', 'ditangguhan', 'tab'
        ));
    }

// ============================================================
//  TRANSAKSI
// ============================================================
public function transaksi(Request $request): View
{
    $cols = Schema::getColumnListing('transactions');

    // Auto-detect kolom nominal (biar tidak "Unknown column 'total'")
    $colNominal = null;
    foreach (['total','total_harga','jumlah','nominal','amount','nilai','harga','grand_total'] as $c) {
        if (in_array($c, $cols)) { $colNominal = $c; break; }
    }

    // ---- Filter dari view ----
    $status = $request->get('status', 'all');   // all|success|failed|pending
    $period = $request->get('period', '30');    // 30|7|1

    $query = Transaction::query();

    if ($status !== 'all' && in_array('status', $cols)) {
        $query->where('status', $status);
    }
    if (in_array('created_at', $cols)) {
        $query->where('created_at', '>=', now()->subDays((int) $period));
    }

    if ($request->filled('search')) {
        $q = $request->search;
        $query->where(function ($b) use ($q) {
            $b->where('id', 'like', "%{$q}%");
        });
    }

    $transactions = $query->orderBy('id', 'desc')
                          ->paginate(10)
                          ->withQueryString(); // pagination ikut membawa filter

    // 👇 Jitu: alias kolom nominal → attribute 'total',
    //    biar view yang pakai $trx->total TETAP jalan walau kolom aslinya beda nama
    $transactions->getCollection()->transform(function ($trx) use ($colNominal) {
        $trx->setAttribute('total', $colNominal ? ($trx->{$colNominal} ?? 0) : 0);
        return $trx;
    });

    // ---- STATS (hanya query kolom yang ada → anti-crash) ----
    $hasStatus = in_array('status', $cols);

    $totalPemasukan = ($colNominal && $hasStatus)
        ? (int) Transaction::where('status', 'success')->sum($colNominal) : 0;

    $transaksiBerhasil = $hasStatus ? Transaction::where('status', 'success')->count() : 0;
    $transaksiGagal    = $hasStatus ? Transaction::whereIn('status', ['failed', 'pending'])->count() : 0;

    // ---- Hari ini ----
    $today = now()->startOfDay();
    $transaksiHariIni = Transaction::where('created_at', '>=', $today)->count();
    $volumeHariIni    = $colNominal
        ? (int) Transaction::where('status', 'success')
                            ->where('created_at', '>=', $today)
                            ->sum($colNominal)
        : 0;

    return view('admin.transaksi', compact(
        'transactions',
        'totalPemasukan', 'transaksiBerhasil', 'transaksiGagal',
        'volumeHariIni', 'transaksiHariIni',
        'status', 'period'
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