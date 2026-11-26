<?php

namespace App\Http\Controllers;

use App\Models\TranslationHistory;
use App\Models\TranslationPhraseUsage;
use App\Services\TranslateLimitService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function __construct(
        private readonly TranslateLimitService $quota,
    ) {}

    public function index(): View
    {
        $user = auth()->user();
        $plan = $user->getCurrentPlan();
        $creditInfo = $this->quota->memberCreditInfo($user);
        $creditPercentage = $creditInfo['is_unlimited']
            ? 100
            : ($creditInfo['max'] > 0
                ? min(100, max(0, ($creditInfo['balance'] / $creditInfo['max']) * 100))
                : 0);

        $historyQuery = TranslationHistory::query()
            ->where('user_id', $user->id);
        $translationHistoryCount = (clone $historyQuery)->count();
        $recentTranslations = $historyQuery
            ->latest()
            ->orderByDesc('id')
            ->limit(4)
            ->get()
            ->map(fn (TranslationHistory $translation): array => [
                'original' => $translation->original_text,
                'translated' => $translation->translated_text,
                'direction' => $translation->direction,
            ]);

        $popularPhrases = TranslationPhraseUsage::popular()
            ->limit(8)
            ->get()
            ->map(fn (TranslationPhraseUsage $phrase): array => [
                'id' => $phrase->indonesian_display,
                'walikan' => $phrase->walikan_display,
            ]);

        return view('member.member-home', compact(
            'plan',
            'creditInfo',
            'creditPercentage',
            'translationHistoryCount',
            'recentTranslations',
            'popularPhrases',
        ));
    }

    public function history(): JsonResponse
    {
        $user = auth()->user();
        $translations = TranslationHistory::query()
            ->where('user_id', $user->id)
            ->latest()
            ->orderByDesc('id')
            ->limit(100)
            ->get()
            ->map(fn (TranslationHistory $translation): array => [
                'id' => $translation->id,
                'original' => $translation->original_text,
                'translated' => $translation->translated_text,
                'direction' => $translation->direction,
                'created_at' => $translation->created_at?->diffForHumans() ?? '',
            ]);

        return response()->json([
            'success' => true,
            'count' => $translations->count(),
            'data' => $translations,
        ]);
    }
}
