<template x-if="filterOpen">
    <div
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
    @click.outside="filterOpen = false"
    class="absolute right-60 top-full z-60"
>
    <div class="w-80 
                bg-white backdrop-blur-xl backdrop-saturate-150
                rounded-2xl shadow-xl 
                border border-white/40
                p-5
                transition-all duration-300">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-semibold text-gray-800">
                Filter Lelang
            </h3>
            <button 
                @click="filterOpen = false"
                class="text-gray-400 hover:text-gray-700 
                       transition-all duration-200 text-sm
                       hover:rotate-90"
            >
                ✕
            </button>
        </div>

        <form method="GET" action="{{ route('lelang.index') }}" class="space-y-4 text-sm" x-ref="filterForm">

            {{-- Kategori --}}
            <div>
                <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-2">
                    Kategori
                </h4>

                @php
                        $activeKategoriChunk = 0;
                        foreach ($categories->chunk(3) as $chunkIdx => $chunk) {
                            foreach ($chunk as $item) {
                                if (request('kategori') == $item->slug) {
                                    $activeKategoriChunk = $chunkIdx;
                                }
                            }
                        }
                @endphp
                <div 
                    x-data="{
                            current: {{ $activeKategoriChunk }},
                            total: {{ ceil(count($categories) / 3) }}
                    }"
                    class="relative"
                >
                
                <div class="overflow-hidden">
                    <div 
                        class="flex transition-transform duration-300"
                        :style="'transform: translateX(-' + (current * 100) + '%)'"
                    >
                        @foreach ($categories->chunk(3) as $chunk)
                            <div class="w-full flex-shrink-0 grid grid-cols-3 gap-3">
                                @foreach ($chunk as $item)
                                    <label class="flex items-center justify-center px-4 py-3 
                                                   border-2 border-gray-200 
                                                   rounded-xl cursor-pointer 
                                                   transition-all duration-200
                                                   hover:border-[#00529C] 
                                                   hover:shadow-sm
                                                   has-[:checked]:border-[#00529C] 
                                                   has-[:checked]:bg-blue-50/70">
                                        
                                        <input type="radio"
                                            name="kategori"
                                            value="{{ $item->slug }}"
                                            class="sr-only peer"
                                            {{ request('kategori') == $item->slug ? 'checked' : '' }}>

                                        <span class="text-sm text-gray-700 
                                                     peer-checked:text-[#00529C] 
                                                     peer-checked:font-semibold 
                                                     transition-colors text-center">
                                            {{ $item->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Indicator --}}
                <div class="flex justify-center gap-2 mt-3">
                    <template x-for="i in total" :key="i">
                        <button
                            type="button"
                            @click="current = i - 1"
                            class="w-2 h-2 rounded-full transition-all duration-300"
                            :class="current === (i - 1) 
                                ? 'bg-[#00529C] scale-125' 
                                : 'bg-gray-300 hover:bg-gray-400'"
                        ></button>
                    </template>
                </div>
            </div>



            {{-- Harga --}}
            <div>
                <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-2">
                    Harga
                </h4>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="min" placeholder="Min"
                        value="{{ request('min') }}"
                        class="input text-xs py-1.5 
                               bg-white/60 backdrop-blur-md
                               border border-white/40
                               focus:ring-2 focus:ring-[#00529C]/40">

                    <input type="text" name="max" placeholder="Max"
                        value="{{ request('max') }}"
                        class="input text-xs py-1.5 
                               bg-white/60 backdrop-blur-md
                               border border-white/40
                               focus:ring-2 focus:ring-[#00529C]/40">
                </div>
                
            </div>

            {{-- Lokasi --}}
            <div>
                <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-2 mt-4">
                    Lokasi
                </h4>

                <div 
                    x-data="{
                        current: 0,
                        total: {{ ceil(count($cities) / 3) }}
                    }"
                    class="relative"
                >
                    <div class="overflow-hidden">
                        <div 
                            class="flex transition-transform duration-300"
                            :style="'transform: translateX(-' + (current * 100) + '%)'"
                        >
                            @foreach ($cities->chunk(3) as $chunk)
                                <div class="w-full flex-shrink-0 grid grid-cols-3 gap-2">
                                    @foreach ($chunk as $kota)
                                        {{-- BUG FIX: was using $item->slug instead of $kota->slug --}}
                                        <label class="flex items-center justify-center px-4 py-3 
                                                    border-2 border-gray-200 
                                                    rounded-xl cursor-pointer 
                                                    transition-all duration-200
                                                    hover:border-[#00529C] 
                                                    hover:shadow-sm
                                                    has-[:checked]:border-[#00529C] 
                                                    has-[:checked]:bg-blue-50/70">

                                            <input type="radio"
                                                name="kota"
                                                value="{{ $kota->slug }}"
                                                class="sr-only"
                                                {{ request('kota') == $kota->slug ? 'checked' : '' }}>

                                            <span class="text-sm text-gray-700 transition-colors text-center
                                                        {{ request('kota') == $kota->slug ? 'text-[#00529C] font-semibold' : '' }}">
                                                {{ $kota->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Indicator --}}
                    @if(ceil(count($cities) / 3) > 1)
                    <div class="flex justify-center gap-2 mt-3">
                        <template x-for="i in total" :key="i">
                            <button
                                type="button"
                                @click="current = i - 1"
                                class="w-2 h-2 rounded-full transition-all duration-300"
                                :class="current === (i - 1) 
                                    ? 'bg-[#00529C] scale-125' 
                                    : 'bg-gray-300 hover:bg-gray-400'"
                            ></button>
                        </template>
                    </div>
                    @endif
                </div>
            </div>





            {{-- Waktu --}}
            <div>
                <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-2">
                    Jadwal
                </h4>
                <div class="grid grid-cols-2 gap-2">
                    <select name="bulan" 
                            class="input text-xs py-1.5 
                                   bg-white/60 backdrop-blur-md
                                   border border-white/40
                                   focus:ring-2 focus:ring-[#00529C]/40">
                        <option value="">Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}"
                                {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>

                    <select class="input text-xs py-1.5 
                                   bg-white/60 backdrop-blur-md
                                   border border-white/40">
                        <option>Minggu</option>
                    </select>
                </div>
            </div>

            {{-- Actions --}}
            <div class="space-y-2 pt-4">
                <button 
                    class="w-full text-xs py-2 
                           rounded-lg
                           bg-[#00529C] text-white 
                           hover:bg-[#003d73]
                           transition-all duration-200 shadow-sm">
                    Terapkan
                </button>

                <a href="{{ route('lelang.index') }}"
                class="block w-full py-2 text-xs rounded-lg border border-[#00529C] text-[#00529C] font-medium hover:bg-blue-50 transition text-center">
                    Reset
                </a>

            </div>

        </form>
     </div>
</template>
