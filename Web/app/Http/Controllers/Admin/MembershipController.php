<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipTier;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $r)
    {
        $filter = $r->get('filter', 'all');
        $query = MembershipTier::query()
            ->withCount([
                'memberships as active_members' => fn ($memberships) => $memberships->where('status', 'active'),
            ]);

        if ($filter === 'active') {
            $query->where('is_active', true);
        }

        $tiers = $query->orderBy('order')->get();

        // Hitung statistik
        $totalPelanggan = Membership::where('status', 'active')->count();

        // MRR = Monthly Recurring Revenue
        $mrr = Membership::where('status', 'active')
            ->join('membership_tiers', 'memberships.membership_tier_id', '=', 'membership_tiers.id_membership_tier')
            ->sum('membership_tiers.monthly_price');

        // ARPU = Average Revenue Per User
        $arpu = $totalPelanggan > 0 ? $mrr / $totalPelanggan : 0;

        // Retensi = (total member aktif / total member ever) * 100
        $totalEver = Membership::count();
        $tingkatRetensi = $totalEver > 0 ? round(($totalPelanggan / $totalEver) * 100, 1) : 0;

        return view('admin.membership', compact(
            'tiers',
            'filter',
            'totalPelanggan',
            'mrr',
            'arpu',
            'tingkatRetensi'
        ));
    }

    public function store(Request $r)
    {
        $data = $this->validateData($r);

        // Simpan features sebagai JSON array dari checkboxes
        $data['features'] = $r->input('privileges', []);

        MembershipTier::create($data);

        return back()->with('success', 'Paket langganan berhasil dikonfigurasi!');
    }

    public function update(Request $r, MembershipTier $membershipTier)
    {
        $data = $this->validateData($r);
        $data['features'] = $r->input('privileges', []);

        $membershipTier->update($data);

        return back()->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy(MembershipTier $membershipTier)
    {
        // Cek apakah ada user yang masih berlangganan tier ini
        $activeMembers = $membershipTier->memberships()
            ->where('status', 'active')
            ->count();

        if ($activeMembers > 0) {
            return back()->with('error', 'Tidak bisa menghapus tier yang masih memiliki pelanggan aktif!');
        }

        $membershipTier->delete();

        return back()->with('success', 'Paket dihapus dari sistem.');
    }

    private function validateData(Request $r)
    {
        return $r->validate([
            'name' => 'required|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'required|numeric|min:0',
            'translation_quota' => 'nullable|integer|min:0',
            'ebook_access' => 'required|in:semua,saku,khusus',
            'privileges' => 'nullable|array',
            'privileges.*' => 'in:audio_nafiri,badge_komunitas,bebas_iklan',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ], [
            'name.required' => 'Nama tier paket wajib diisi.',
            'monthly_price.required' => 'Harga bulanan wajib diisi.',
            'yearly_price.required' => 'Harga tahunan wajib diisi.',
            'ebook_access.required' => 'Hak akses e-book wajib dipilih.',
        ]);
    }
}
