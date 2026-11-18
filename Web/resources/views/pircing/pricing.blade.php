@foreach ($tiers as $tier)
    @php
        $isRecommended = $tier->is_recommended;
    @endphp
    <div class="relative {{ $isRecommended ? 'md:-mt-4 md:mb-4' : '' }}">
        @if ($isRecommended)
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                <span class="bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg">
                    <i class="fas fa-crown mr-1"></i> PALING DIREKOMENDASIKAN
                </span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg h-full flex flex-col overflow-hidden border-2 {{ $isRecommended ? 'border-blue-500' : 'border-transparent' }}">
            <div class="p-6 border-b border-gray-100">
                @if ($tier->badge)
                    <span class="inline-block text-[10px] font-bold px-2.5 py-1 rounded-md bg-blue-100 text-blue-700 mb-3 uppercase tracking-wide">
                        {{ $tier->badge }}
                    </span>
                @endif
                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $tier->name }}</h3>
                <p class="text-sm text-gray-500">{{ $tier->description }}</p>

                <div class="mt-5 flex items-baseline gap-1">
                    <span class="text-sm text-gray-500">Rp</span>
                    <span class="text-4xl font-extrabold text-gray-900 price-value"
                          data-monthly="{{ $tier->monthly_price }}"
                          data-yearly="{{ $tier->yearly_price ?? ($tier->monthly_price * 12) }}">
                        {{ number_format($tier->monthly_price, 0, ',', '.') }}
                    </span>
                    <span class="text-sm text-gray-500 billing-period">/bulan</span>
                </div>
            </div>

            <div class="p-6 flex-1">
                <ul class="space-y-3">
                    @forelse ($tier->features as $feature)
                        <li class="flex items-start gap-3">
                            @if ($feature->included)
                                <i class="fas fa-check-circle text-blue-500 mt-0.5"></i>
                                <span class="text-sm text-gray-700">{{ $feature->feature }}</span>
                            @else
                                <i class="fas fa-times-circle text-gray-300 mt-0.5"></i>
                                <span class="text-sm text-gray-400 line-through">{{ $feature->feature }}</span>
                            @endif
                        </li>
                    @empty
                        {{-- Fallback jika belum ada tabel features --}}
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-blue-500 mt-0.5"></i>
                            <span class="text-sm text-gray-700">Akses fitur dasar {{ $tier->name }}</span>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="p-6 pt-0">
                <button onclick="selectPlan('{{ $tier->name }}', {{ $tier->monthly_price }})"
                        class="w-full py-3 rounded-xl font-bold text-sm transition-all duration-300
                               {{ $isRecommended
                                    ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:shadow-lg'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $tier->monthly_price === 0 ? 'Pakai Gratis' : 'Pilih ' . $tier->name }}
                </button>
            </div>
        </div>
    </div>
@endforeach