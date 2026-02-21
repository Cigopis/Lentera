<div x-data="{ filterOpen: false, mobileOpen: false }">

<nav 
    class="fixed top-0 inset-x-0 z-[100] 
           bg-white/70 backdrop-blur-xl backdrop-saturate-150
           border-b border-white/30 
           shadow-sm transition-all duration-500"
>
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center h-16">

            <!-- Logo -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo140x71.svg') }}" 
                     alt="Lentera" 
                     class="h-10 transition duration-300 hover:scale-105">
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-6 text-sm ml-auto">

                <!-- Beranda -->
                <a href="{{ route('home') }}"
                   class="relative transition-all duration-300
                   {{ request()->routeIs('home') 
                        ? 'text-[#00529C] font-semibold after:absolute after:-bottom-2 after:left-0 after:w-full after:h-[2px] after:bg-[#00529C]' 
                        : 'text-gray-700 hover:text-[#00529C]' }}">
                    Beranda
                </a>

                <!-- Filter Lelang -->
                <button type="button" 
                        @click="filterOpen = !filterOpen"
                        class="relative transition-all duration-300
                        {{ request()->routeIs('lelang.*') 
                            ? 'text-[#00529C] font-semibold after:absolute after:-bottom-2 after:left-0 after:w-full after:h-[2px] after:bg-[#00529C]' 
                            : 'text-gray-700 hover:text-[#00529C]' }}">
                    Filter Lelang
                </button>

                <!-- Pusat Bantuan -->
                <a href="{{ route('help') }}"
                   class="relative transition-all duration-300
                   {{ request()->routeIs('help') 
                        ? 'text-[#00529C] font-semibold after:absolute after:-bottom-2 after:left-0 after:w-full after:h-[2px] after:bg-[#00529C]' 
                        : 'text-gray-700 hover:text-[#00529C]' }}">
                    Pusat Bantuan
                </a>

                <form method="GET" action="{{ route('lelang.index') }}" 
                    class="relative w-56 group">

                    <input type="text" 
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari aset..."
                        class="w-full rounded-full 
                                bg-white/80 backdrop-blur-md
                                border border-[#00529C]
                                pl-4 pr-10 py-2 text-[13px]
                                text-gray-700 placeholder-gray-500
                                transition-all duration-300
                                focus:outline-none focus:ring-2 focus:ring-[#00529C]/40">

                    <button type="submit"
                            class="absolute right-3 top-1/2 -translate-y-1/2 
                                text-gray-500 hover:text-[#00529C] transition">

                        <x-heroicon-o-magnifying-glass class="w-4 h-4"/>
                    </button>
                </form>


            </div>

            <!-- Hamburger -->
            <button 
                @click="mobileOpen = !mobileOpen"
                type="button"
                class="md:hidden ml-auto p-2 text-gray-700 
                       hover:bg-white/60 rounded-lg transition">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Desktop Filter -->
    <div class="hidden md:block relative">
        <div 
            x-show="filterOpen" 
            x-cloak 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            @click.outside="filterOpen = false" 
            class="absolute right-20 top-full mt-3 z-40"
        >
            <x-filter-lelang />
        </div>
    </div>
</nav>


<!-- Mobile Overlay -->
<div 
    x-show="mobileOpen"
    x-cloak
    @click="mobileOpen = false"
    class="fixed inset-0 bg-black/30 backdrop-blur-sm z-[110] md:hidden"
></div>


<!-- Mobile Sidebar -->
<div
    x-show="mobileOpen"
    x-cloak
    class="fixed top-0 right-0 bottom-0 z-[120] 
           h-full w-80 
           bg-white/85 backdrop-blur-2xl
           border-l border-white/30
           shadow-2xl md:hidden flex flex-col"
    x-transition:enter="transform transition ease-out duration-400"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transform transition ease-in duration-300"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
>

    <!-- Header -->
    <div class="flex items-center justify-between px-6 h-16 border-b border-white/30">
        <h3 class="font-semibold text-base text-gray-800">Menu & Filter</h3>
        <button @click="mobileOpen = false" 
                class="p-2 text-gray-500 hover:bg-white/60 rounded-lg transition">
            ✕
        </button>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6 text-sm text-gray-700">

        <form method="GET" action="{{ route('lelang.index') }}" 
            class="relative">

            <input type="text" 
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari aset..."
                class="w-full rounded-full 
                        bg-white/60 backdrop-blur-md
                        border border-white/40
                        pl-4 pr-10 py-2 text-sm
                        focus:outline-none focus:ring-2 focus:ring-[#00529C]/40">

            <button type="submit"
                    class="absolute right-3 top-1/2 -translate-y-1/2 
                        text-gray-500 hover:text-[#00529C] transition">

                <x-heroicon-o-magnifying-glass class="w-5 h-5"/>
            </button>
        </form>


        <a href="{{ route('home') }}" 
           class="block {{ request()->routeIs('home') ? 'text-[#00529C] font-semibold' : 'hover:text-[#00529C]' }}">
            Beranda
        </a>

        <a href="{{ route('help') }}" 
           class="block {{ request()->routeIs('help') ? 'text-[#00529C] font-semibold' : 'hover:text-[#00529C]' }}">
            Pusat Bantuan
        </a>

        <!-- FILTER LELANG (STRUKTUR ASLI TETAP) -->
        <div class="pt-6 border-t border-white/30">
            <h4 class="font-semibold mb-2 text-gray-900">Filter Lelang</h4>

            <form method="GET" action="{{ route('lelang.index') }}" class="space-y-6 text-sm">

                {{-- KATEGORI --}}
                <div>
                    <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-1">Kategori</h4>
                    <div x-data="{ current: 0, total: {{ ceil(count($categories) / 3) }} }" class="relative">
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-300"
                                 :style="'transform: translateX(-' + (current * 100) + '%)'">
                                @foreach ($categories->chunk(3) as $chunk)
                                    <div class="w-full flex-shrink-0 grid grid-cols-3 gap-3">
                                        @foreach ($chunk as $item)
                                            <label class="flex items-center justify-center px-3 py-2 border-2 border-gray-200 rounded-lg cursor-pointer transition-all hover:border-[#00529C] has-[:checked]:border-[#00529C] has-[:checked]:bg-blue-50">
                                                <input type="radio" name="kategori"
                                                       value="{{ $item->slug }}"
                                                       class="sr-only peer"
                                                       {{ request('kategori') == $item->slug ? 'checked' : '' }}>
                                                <span class="text-xs text-gray-700 peer-checked:text-[#00529C] peer-checked:font-semibold text-center">
                                                    {{ $item->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-center gap-2 mt-1">
                            <template x-for="i in total" :key="i">
                                <button type="button"
                                        @click="current = i - 1"
                                        class="w-2 h-2 rounded-full transition-all"
                                        :class="current === (i - 1) ? 'bg-[#00529C]' : 'bg-gray-300'">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- HARGA --}}
                <div>
                    <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-1">Harga</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="min" value="{{ request('min') }}"
                               placeholder="Min" class="input text-xs py-2">
                        <input type="text" name="max" value="{{ request('max') }}"
                               placeholder="Max" class="input text-xs py-2">
                    </div>
                </div>

                {{-- LOKASI --}}
                <div>
                    <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-1">Lokasi</h4>
                    <div x-data="{ current: 0, total: Math.ceil({{ count($cities) }} / 6) }" class="relative">
                        <div class="overflow-hidden">
                            <div class="flex transition-all duration-300"
                                 :style="'transform: translateX(-' + (current * 100) + '%)'">
                                @foreach ($cities->chunk(6) as $chunk)
                                    <div class="min-w-full flex flex-wrap gap-2 justify-center">
                                        @foreach ($chunk as $kota)
                                            <label class="filter-chip px-3 py-1 text-xs cursor-pointer transition-all hover:border-[#00529C] has-[:checked]:border-[#00529C] has-[:checked]:bg-blue-50">
                                                <input type="radio"
                                                    name="kota"
                                                    value="{{ $kota->slug }}"
                                                    class="sr-only peer"
                                                    {{ request('kota') == $kota->slug ? 'checked' : '' }}>
                                                <span class="peer-checked:text-[#00529C] font-medium peer-checked:font-semibold">
                                                    {{ $kota->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-center gap-2 mt-1">
                            <template x-for="i in total" :key="i">
                                <button type="button"
                                        @click="current = i - 1"
                                        class="w-2 h-2 rounded-full transition-all"
                                        :class="current === (i - 1) ? 'bg-[#00529C]' : 'bg-gray-300'">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- JADWAL --}}
                <div>
                    <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-1">Jadwal</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <select name="bulan" class="input text-xs py-2">
                            <option value="">Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}"
                                    {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                        <select class="input text-xs py-2">
                            <option>Minggu</option>
                        </select>
                    </div>
                </div>

                {{-- ACTION --}}
                <div class="space-y-3 pt-1">
                    <button type="submit"
                            class="w-full py-2 text-xs rounded-lg bg-[#00529C] text-white font-semibold hover:bg-[#003d73] transition">
                        Terapkan
                    </button>
                    <a href="{{ route('lelang.index') }}"
                    class="block w-full py-2 text-xs rounded-lg border border-[#00529C] text-[#00529C] font-medium hover:bg-blue-50 transition text-center">
                        Reset
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

</div>


@push('styles')
<style>
[x-cloak] { display: none !important; }

nav {
    animation: fadeGlass 0.6s ease-out;
}

@keyframes fadeGlass {
    from { opacity: 0; backdrop-filter: blur(0px); }
    to { opacity: 1; backdrop-filter: blur(20px); }
}
</style>
@endpush
