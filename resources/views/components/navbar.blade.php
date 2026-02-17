
<div x-data="{ filterOpen: false, mobileOpen: false }">

<nav class="fixed top-0 inset-x-0 z-[100] bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center h-16">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo140x71.svg') }}" alt="Lentera" class="h-10">
            </div>

            <div class="hidden md:flex items-center gap-6 text-sm ml-auto">

                <!-- Beranda -->
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') 
                        ? 'text-[#00529C] font-medium border-b-2 border-[#00529C] pb-1' 
                        : 'text-gray-700 hover:text-[#00529C]' }}">
                    Beranda
                </a>

                <!-- Filter Lelang -->
                <button type="button" @click="filterOpen = !filterOpen"
                    class="{{ request()->routeIs('lelang.*') 
                        ? 'text-[#00529C] font-semibold border-b-2 border-[#00529C] pb-1' 
                        : 'text-gray-700 hover:text-[#00529C]' }}">
                    Filter Lelang
                </button>

                <!-- Pusat Bantuan -->
                <a href="{{ route('help') }}"
                    class="{{ request()->routeIs('help') 
                        ? 'text-[#00529C] font-semibold border-b-2 border-[#00529C] pb-1' 
                        : 'text-gray-700 hover:text-[#00529C]' }}">
                    Pusat Bantuan
                </a>

                <!-- Search -->
                <div class="relative w-56">
                    <input type="text" placeholder="Cari..."
                        class="w-full rounded-full border border-blue-500 pl-4 pr-9 py-1.5 text-[13px] focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[#00529C]">🔍</span>
                </div>

            </div>


            {{-- Hamburger Button --}}
            <button 
                @click="mobileOpen = !mobileOpen"
                type="button"
                class="md:hidden ml-auto p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Desktop Filter --}}
    <div class="hidden md:block relative">
        <div x-show="filterOpen" x-cloak x-transition @click.outside="filterOpen = false" class="absolute right-20 top-full mt-0 z-40">
            <x-filter-lelang />
        </div>
    </div>
</nav>

{{-- Mobile Overlay --}}
<div 
    x-show="mobileOpen"
    @click="mobileOpen = false"
    x-cloak
    class="fixed inset-0 bg-black/50 z-[110] md:hidden"
></div>

{{-- Mobile Sidebar --}}
<div
    x-show="mobileOpen"
    x-cloak
    class="fixed top-0 right-0 bottom-0 z-[120] h-full w-80 bg-white shadow-2xl md:hidden flex flex-col"
    x-transition:enter="transform transition ease-out duration-300"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
>
    {{-- Header --}}
    <div class="flex items-center justify-between px-6 h-16 border-b bg-white">
        <h3 class="font-semibold text-base">Menu & Filter</h3>
        <button @click="mobileOpen = false" type="button" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Content --}}
    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6 text-sm text-gray-700">
        <input type="text" placeholder="Cari..." class="w-full rounded-full border border-blue-500 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        
        <a href="{{ route('home') }}" class="block {{ request()->routeIs('home') ? 'text-[#00529C] font-semibold' : 'text-gray-700 hover:text-[#00529C]' }}">Beranda</a>
        <a href="{{ route('help') }}" class="block {{ request()->routeIs('help') ? 'text-[#00529C] font-semibold' : 'text-gray-700 hover:text-[#00529C]' }}">Pusat Bantuan</a>


        <div class="pt-6 border-t">
            <h4 class="font-semibold mb-2 text-gray-900">Filter Lelang</h4>
            <form method="GET" action="{{ route('lelang.index') }}" class="space-y-6 text-sm">
                
                {{-- KATEGORI --}}
                <div>
                    <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-1">Kategori</h4>
                    <div x-data="{ current: 0, total: {{ ceil(count($categories) / 3) }} }" class="relative">
                        <div class= "overflow-hidden">
                            <div class="flex transition-transform duration-300" :style="'transform: translateX(-' + (current * 100) + '%)'">
                                @foreach ($categories->chunk(3) as $chunk)
                                    <div class="w-full flex-shrink-0 grid grid-cols-3 gap-3">
                                        @foreach ($chunk as $item)
                                            <label class="flex items-center justify-center px-3 py-2 border-2 border-gray-200 rounded-lg cursor-pointer transition-all hover:border-[#00529C] has-[:checked]:border-[#00529C] has-[:checked]:bg-blue-50">
                                                <input type="radio" name="kategori" value="{{ $item->slug }}" class="sr-only peer" {{ request('kategori') == $item->slug ? 'checked' : '' }}>
                                                <span class="text-xs text-gray-700 peer-checked:text-[#00529C] peer-checked:font-semibold text-center">{{ $item->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex justify-center gap-2 mt-1">
                            <template x-for="i in total" :key="i">
                                <button type="button" @click="current = i - 1" class="w-2 h-2 rounded-full transition-all" :class="current === (i - 1) ? 'bg-[#00529C]' : 'bg-gray-300'"></button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- HARGA --}}
                <div>
                    <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-1">Harga</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="min" placeholder="Min" value="{{ request('min') }}" class="input text-xs py-2">
                        <input type="text" name="max" placeholder="Max" value="{{ request('max') }}" class="input text-xs py-2">
                    </div>
                </div>

                {{-- LOKASI --}}
                <div>
                    <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-1">Lokasi</h4>
                    <div x-data="{ current: 0, total: Math.ceil({{ count($cities) }} / 6) }" class="relative">
                        <div class="overflow-hidden">
                            <div class="flex transition-all duration-300" :style="'transform: translateX(-' + (current * 100) + '%)'">
                                @foreach ($cities->chunk(6) as $chunk)
                                    <div class="min-w-full flex flex-wrap gap-2 justify-center">
                                        @foreach ($chunk as $kota)
                                            <label class="filter-chip px-3 py-1 text-xs cursor-pointer transition-all hover:border-[#00529C] has-[:checked]:border-[#00529C] has-[:checked]:bg-blue-50">
                                                <input type="checkbox" name="kota[]" value="{{ $kota->slug }}" class="sr-only peer" {{ in_array($kota->slug, request('kota', [])) ? 'checked' : '' }}>
                                                <span class="peer-checked:text-[#00529C] font-medium peer-checked:font-semibold">{{ $kota->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex justify-center gap-2 mt-1">
                            <template x-for="i in total" :key="i">
                                <button type="button" @click="current = i - 1" class="w-2 h-2 rounded-full transition-all" :class="current === (i - 1) ? 'bg-[#00529C]' : 'bg-gray-300'"></button>
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
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                            @endfor
                        </select>
                        <select class="input text-xs py-2">
                            <option>Minggu</option>
                        </select>
                    </div>
                </div>

                {{-- ACTION --}}
                <div class="space-y-3 pt-1">
                    <button type="submit" class="w-full py-2 text-xs rounded-lg bg-[#00529C] text-white font-semibold hover:bg-[#003d73] transition">Terapkan</button>
                    <button type="reset" class="w-full py-2 text-xs rounded-lg border border-[#00529C] text-[#00529C] font-medium hover:bg-blue-50 transition">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div> {{-- Close wrapper div --}}

<script>
    // Tidak perlu script global lagi
</script>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush