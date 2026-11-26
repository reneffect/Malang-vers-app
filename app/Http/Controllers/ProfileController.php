<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $membership = $user->activeMembership()->with('tier')->first();
        $currentPlan = $membership?->tier ?? $user->getCurrentPlan();

        return view('member.profile-member', [
            'user' => $user,
            'membership' => $membership,
            'currentPlan' => $currentPlan,
            'ebookCollectionCount' => $user->ownedEbooks()->count(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'tanggal_lahir' => ['nullable', 'date'],
            'kota' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:160'],
            'alias_osob' => ['nullable', 'string', 'max:255'],
        ]);

        $safeData = collect($validated)->only(['name', 'email', 'phone', 'tanggal_lahir', 'kota', 'bio', 'alias_osob'])->all();
        $user->update($safeData);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Kata sandi berhasil diperbarui.');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return response()->json([
            'success' => true,
            'url' => asset('storage/'.$path),
        ]);
    }
}
