<button
    type="button"
    onclick="usePhrase(this.dataset.id, this.dataset.walikan)"
    data-id="{{ $id }}"
    data-walikan="{{ $walikan }}"
    class="flex flex-col gap-1 rounded-xl border border-slate-100 bg-slate-50 p-3 text-left transition hover:border-primary-200 hover:bg-primary-50"
>
    <span class="text-sm font-semibold text-slate-800">{{ $id }}</span>
    <span class="text-xs text-primary-600">{{ $walikan }}</span>
</button>