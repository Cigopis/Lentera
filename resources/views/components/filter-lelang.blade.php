<div
    x-show="filterOpen"
    x-cloak
    x-transition.origin.top.right
    @click.outside="filterOpen = false"
    class="absolute right-60 top-full mt-1 z-60"
>
    <div class="w-80 bg-white rounded-xl shadow-lg border p-4">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-semibold">Filter Lelang</h3>
            <button 
                @click="filterOpen = false"
                class="text-gray-400 hover:text-black text-sm"
            >
                ✕
            </button>
        </div>

        <form method="GET" action="{{ route('lelang.index') }}" class="space-y-4 text-sm">

            {{-- Kategori --}}
            <div>
                <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-2">
                    Kategori
                </h4>

                <div 
                    x-data="{
                        current: 0,
                        perPage: 3,
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
                                    <label class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-lg cursor-pointer transition-all hover:border-[#00529C] has-[:checked]:border-[#00529C] has-[:checked]:bg-blue-50">
                                        
                                        <input type="radio"
                                            name="kategori"
                                            value="{{ $item->slug }}"
                                            class="sr-only peer"
                                            {{ request('kategori') == $item->slug ? 'checked' : '' }}>

                                        <span class="text-sm text-gray-700 peer-checked:text-[#00529C] peer-checked:font-semibold transition-colors text-center">
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
                                class="w-2 h-2 rounded-full transition-all"
                                :class="current === (i - 1) ? 'bg-[#00529C]' : 'bg-gray-300'"
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
                        class="input text-xs py-1.5">
                    <input type="text" name="max" placeholder="Max"
                        value="{{ request('max') }}"
                        class="input text-xs py-1.5">
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
                        total: Math.ceil({{ count($cities) }} / 6),
                    }"
                    class="relative"
                >
                <div class="overflow-hidden">
                    <div 
                        class="flex transition-all duration-300"
                        :style="'transform: translateX(-' + (current * 100) + '%)'"
                    >
                        @foreach ($cities->chunk(6) as $chunk)
                            <div class="min-w-full flex flex-wrap gap-2 justify-center">
                                @foreach ($chunk as $kota)
                                    <label class="filter-chip px-3 py-1 text-xs cursor-pointer transition-all hover:border-[#00529C] has-[:checked]:border-[#00529C] has-[:checked]:bg-blue-50">

                                        <input type="checkbox"
                                            name="kota[]"
                                            value="{{ $kota->slug }}"
                                            class="sr-only peer"
                                            {{ in_array($kota->slug, request('kota', [])) ? 'checked' : '' }}>

                                        <span class="peer-checked:text-[#00529C] font-medium peer-checked:font-semibold transition-colors">
                                            {{ $kota->name }}
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
                            class="w-2 h-2 rounded-full transition-all"
                            :class="current === (i - 1) ? 'bg-[#00529C]' : 'bg-gray-300'"
                        ></button>
                    </template>
                </div>

            </div>



            {{-- Waktu --}}
            <div>
                <h4 class="text-[11px] font-semibold text-[#00529C] tracking-wide mb-2">
                    Jadwal
                </h4>
                <div class="grid grid-cols-2 gap-2">
                    <select name="bulan" class="input text-xs py-1.5">
                        <option value="">Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}"
                                {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>

                    <select class="input text-xs py-1.5">
                        <option>Minggu</option>
                    </select>
                </div>
            </div>

            {{-- Actions --}}
            <div class="space-y-2 pt-2">
                <button class="btn-primary w-full text-xs py-2 !bg-[#00529C] text-white">
                    Terapkan
                </button>
                <button type="reset" class="btn-outline w-full text-xs py-2 text-[#00529C]">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
