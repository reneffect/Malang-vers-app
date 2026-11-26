<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipTier;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $tiers = MembershipTier::query()
            ->withCount([
                'memberships as active_members' => fn ($q) => $q->where('status', 'active'),
            ])
            ->orderBy('order')
            ->get();

        return view('admin.membership', compact('tiers', 'filter'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = true;

        MembershipTier::create($data);

        return redirect()
            ->route('admin.membership')
            ->with('success', 'Paket berhasil ditambahkan.');
    }

    public function update(Request $request, MembershipTier $membershipTier)
    {
        $membershipTier->update($this->validated($request));

        return redirect()
            ->route('admin.membership')
            ->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(MembershipTier $membershipTier)
    {
        $membershipTier->delete();

        return redirect()
            ->route('admin.membership')
            ->with('success', 'Paket berhasil dihapus.');
    }

    public function toggle(MembershipTier $membershipTier)
    {
        $membershipTier->update(['is_active' => ! $membershipTier->is_active]);

        return back();
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'              => 'required|string|max:100',
            'tagline'           => 'nullable|string|max:150',
            'monthly_price'     => 'required|numeric|min:0',
            'yearly_price'      => 'required|numeric|min:0',
            'translation_quota' => 'nullable|integer|min:0',
            'ebook_access'      => 'required|in:semua,saku,khusus',
            'privileges'        => 'nullable|array',
            'privileges.*'      => 'string',
        ]);

        $data['benefits'] = $data['privileges'] ?? [];
        unset($data['privileges']);

        return $data;
    }
}