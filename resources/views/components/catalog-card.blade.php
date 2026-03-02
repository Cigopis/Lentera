@props([
    'catalog',
    'layout' => 'horizontal'
])

<a href="{{ route('lelang.show', $catalog->slug) }}" 
   class="group block relative overflow-hidden 
          bg-white
          border border-slate-200
          rounded-2xl md:rounded-3xl 
          h-full
          transition duration-300
          hover:-translate-y-1 
          hover:shadow-lg hover:shadow-slate-200/70">

    @if($layout === 'vertical')

        {{-- ================= VERTICAL (MARKETPLACE STYLE) ================= --}}
        
        {{-- IMAGE --}}
        <div class="relative overflow-hidden rounded-t-2xl md:rounded-t-3xl">
            <div class="grid gap-0.5 bg-slate-100" style="grid-template-columns: 2fr 1fr; height: 200px;">

                {{-- FOTO UTAMA (KIRI) --}}
                <div class="relative overflow-hidden">
                    <img 
                        src="{{ $catalog->primaryImage?->image_path 
                            ? asset('storage/'.$catalog->primaryImage->image_path) 
                            : asset('img/default.jpg') }}"
                        class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                    >
                </div>

                {{-- 3 FOTO KECIL (KANAN) --}}
                <div class="grid grid-rows-3 gap-0.5">
                    @for($i = 1; $i <= 3; $i++)
                        @php $image = $catalog->catalogImages->get($i); @endphp
                        <div class="relative overflow-hidden">
                            @if($image)
                                <img 
                                    src="{{ asset('storage/'.$image->image_path) }}"
                                    class="w-full h-full object-cover"
                                >
                                @if($i == 3 && $catalog->catalogImages->count() > 4)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="text-white text-[10px] md:text-xs font-bold">
                                            +{{ $catalog->catalogImages->count() - 4 }} foto
                                        </span>
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-full bg-slate-200"></div>
                            @endif
                        </div>
                    @endfor
                </div>

            </div>

            {{-- STATUS BADGE --}}
            <div class="absolute top-2 right-2">
                <span class="px-1.5 py-0.5 md:px-2 md:py-1 text-[9px] md:text-[11px] font-semibold rounded-full
                    {{ $catalog->status == 'active' 
                        ? 'bg-emerald-100 text-emerald-600' 
                        : 'bg-slate-100 text-slate-500' }}">
                    {{ $catalog->status_label }}
                </span>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="p-2 md:p-4 flex flex-col flex-1">

            {{-- CATEGORY --}}
            <span class="text-[9px] md:text-[11px] font-semibold text-blue-600 uppercase tracking-wide mb-0.5 md:mb-1">
                {{ $catalog->category->name ?? 'Lentera' }}
            </span>

            {{-- TITLE --}}
            <h3 class="text-[11px] md:text-base font-semibold text-slate-800 
                       line-clamp-2 leading-snug mb-1 md:mb-2
                       group-hover:text-blue-600 transition">
                {{ $catalog->title }}
            </h3>

            {{-- LOCATION --}}
            <p class="text-[9px] md:text-xs text-slate-400 mb-2 md:mb-3">
                {{ $catalog->city->name }}
            </p>

            {{-- PRICE --}}
            <div class="space-y-1 md:space-y-2 mb-2 md:mb-3">

                <div class="bg-blue-50 rounded-lg md:rounded-xl px-2 py-1 md:px-3 md:py-2">
                    <p class="text-[8px] md:text-[11px] text-slate-400">Limit</p>
                    <p class="text-blue-600 font-semibold text-[9px] md:text-sm leading-tight">
                        {{ $catalog->formatted_reserve_price }}
                    </p>
                </div>

                <div class="bg-violet-50 rounded-lg md:rounded-xl px-2 py-1 md:px-3 md:py-2">
                    <p class="text-[8px] md:text-[11px] text-slate-400">Jaminan</p>
                    <p class="text-violet-600 font-semibold text-[9px] md:text-sm leading-tight">
                        {{ $catalog->formatted_deposit_amount }}
                    </p>
                </div>

            </div>

            {{-- TANGGAL LELANG --}}
            <div class="space-y-1 mb-2 md:mb-3">
                <div class="flex justify-between items-center">
                    <p class="text-[8px] md:text-[11px] text-slate-400">Batas Setor Jaminan</p>
                    <p class="text-[8px] md:text-[11px] font-medium text-slate-600">
                        {{ $catalog->auction_date->subDay()->format('d M Y') }}
                    </p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-[8px] md:text-[11px] text-slate-400">Batas Penawaran</p>
                    <p class="text-[8px] md:text-[11px] font-medium text-slate-600">
                        {{ $catalog->auction_date->format('d M Y') }}
                    </p>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="mt-auto flex justify-between items-center pt-1 md:pt-2 border-t border-slate-100">
                <span class="text-[8px] md:text-xs text-slate-400">
                    {{ $catalog->auction_date->format('d M Y') }}
                </span>
                <span class="text-[9px] md:text-xs text-blue-600 font-medium group-hover:underline">
                    Detail →
                </span>
            </div>

        </div>

    @else

        {{-- ================= HORIZONTAL (DEFAULT) ================= --}}
        
        <div class="flex flex-col md:flex-row gap-4 md:gap-6 p-4 md:p-6">

            {{-- IMAGE --}}
            <div class="w-full md:w-5/12 relative overflow-hidden 
                        rounded-xl md:rounded-2xl aspect-[4/3]">

                <img 
                    src="{{ $catalog->primaryImage?->image_path 
                        ? asset('storage/'.$catalog->primaryImage->image_path) 
                        : asset('img/default.jpg') }}"
                    class="w-full h-full object-cover 
                           transition duration-700 
                           group-hover:scale-105"
                >

                <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent"></div>
            </div>

            {{-- CONTENT --}}
            <div class="w-full md:w-7/12 flex flex-col justify-between flex-1">

                <div>

                    {{-- STATUS --}}
                    <div class="flex justify-between items-center mb-2">

                        <span class="text-blue-500 font-semibold text-[11px] tracking-wide uppercase">
                            {{ $catalog->category->name ?? 'Lentera' }}
                        </span>

                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold
                            {{ $catalog->status == 'active' 
                                ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' 
                                : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                            {{ $catalog->status_label }}
                        </span>

                    </div>

                    {{-- LOCATION --}}
                    <p class="text-xs text-slate-400 mb-2">
                        {{ $catalog->city->name }}
                    </p>

                    {{-- TITLE --}}
                    <h3 class="text-base font-semibold mb-2 
                               text-slate-800
                               line-clamp-2 group-hover:text-blue-600 transition">
                        {{ $catalog->title }}
                    </h3>

                    {{-- DESCRIPTION --}}
                    <p class="text-slate-400 text-sm 
                              mb-3 line-clamp-2 leading-relaxed">
                        {{ Str::limit(strip_tags($catalog->description), 90) }}
                    </p>

                    {{-- PRICE --}}
                    <div class="grid grid-cols-2 gap-2 text-sm mb-3">

                        <div class="bg-blue-50 rounded-xl p-3">
                            <p class="text-slate-400 mb-1">Limit</p>
                            <p class="text-blue-600 font-bold text-[12px]">
                                {{ $catalog->formatted_reserve_price }}
                            </p>
                        </div>

                        <div class="bg-violet-50 rounded-xl p-3">
                            <p class="text-slate-400 mb-1">Jaminan</p>
                            <p class="text-violet-600 font-bold text-[12px]">
                                {{ $catalog->formatted_deposit_amount }}
                            </p>
                        </div>

                    </div>

                    <p class="text-slate-400 text-xs">
                        {{ $catalog->auction_date->format('d M Y') }}
                    </p>

                </div>

                {{-- CTA --}}
                <div class="mt-3 text-right text-blue-500 text-sm font-semibold opacity-0 group-hover:opacity-100 transition">
                    Detail →
                </div>

            </div>

        </div>

    @endif

</a>