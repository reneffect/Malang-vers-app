<button
    type="button"
    data-phrase-id="{{ $id }}"
    data-phrase-walikan="{{ $walikan }}"
    class="inline-flex items-center gap-1.5 rounded-full border border-slate-200/90 bg-[#F4F7FF] px-3.5 sm:px-4 py-1.5 sm:py-2 text-left transition-all hover:border-blue-300 hover:bg-blue-50 active:scale-95 cursor-pointer shadow-2xs"
>
    <span class="text-xs sm:text-sm font-bold text-slate-800">{{ $walikan }}</span>
    <span class="text-xs text-slate-400 font-normal">→</span>
    <span class="text-xs sm:text-sm text-slate-400 font-normal">{{ $id }}</span>
</button>
