<article class="rounded-3xl sm:rounded-full bg-[#F4F7FF] border border-[#E7ECF9] px-5 sm:px-6 py-3.5 flex items-center justify-between gap-3 transition-colors hover:bg-[#EEF3FE]">
    <div class="flex-1 min-w-0">
        <p class="text-xs sm:text-sm text-slate-800 leading-snug">
            <span class="font-bold text-blue-600">Osob Kiwalan:</span>
            <span class="font-bold text-slate-800 ml-1">"{{ $original }}"</span>
        </p>
        <p class="mt-1 text-xs sm:text-sm text-slate-500 leading-snug flex items-center gap-1.5">
            <span class="text-slate-400 font-normal">→</span>
            <span>{{ $translated }}</span>
        </p>
    </div>
    <button
        type="button"
        onclick="copyHistoryText(this)"
        data-text="{{ $translated }}"
        class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-white transition-colors cursor-pointer"
        aria-label="Salin terjemahan"
        title="Salin terjemahan"
    >
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
        </svg>
    </button>
</article>
