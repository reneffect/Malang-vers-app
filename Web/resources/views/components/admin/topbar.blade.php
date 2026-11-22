<header class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="flex items-center justify-between px-8 py-4">
        
        {{-- Search Bar --}}
        <div class="flex-1 max-w-xl">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" 
                       placeholder="Cari kamus atau penulis..."
                       class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm
                              focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 
                              focus:ring-blue-500/10 transition-all">
            </div>
        </div>

        {{-- Profile Admin --}}
        <div class="flex items-center gap-3 ml-6">
            <div class="text-right">
                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Sam Admin' }}</p>
                <p class="text-[11px] text-gray-500">Super Administrator</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 
                        flex items-center justify-center text-white font-bold text-sm shadow-md">
                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
            </div>
            <button class="text-gray-400 hover:text-gray-600 ml-1">
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
        </div>

    </div>
</header>