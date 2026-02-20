@props([
    'catalog',
    'layout' => 'horizontal'
])

<a href="{{ route('auction.show', $catalog->slug) }}" 
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
        <div class="relative aspect-[4/3] overflow-hidden">
            <img 
                src="{{ $catalog->primaryImage?->image_path 
                    ? asset('storage/'.$catalog->primaryImage->image_path) 
                    : asset('img/default.jpg') }}"
                class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
            >

            <div class="absolute top-3 right-3">
                <span class="px-2 py-1 text-[11px] font-semibold rounded-full
                    {{ $catalog->status == 'active' 
                        ? 'bg-emerald-100 text-emerald-600' 
                        : 'bg-slate-100 text-slate-500' }}">
                    {{ $catalog->status_label }}
                </span>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="p-4 flex flex-col flex-1">

            {{-- CATEGORY --}}
            <span class="text-[11px] font-semibold text-blue-600 uppercase tracking-wide mb-1">
                {{ $catalog->category->name ?? 'Lentera' }}
            </span>

            {{-- TITLE --}}
            <h3 class="text-sm md:text-base font-semibold text-slate-800 
                       line-clamp-2 leading-snug mb-2 
                       group-hover:text-blue-600 transition">
                {{ $catalog->title }}
            </h3>

            {{-- LOCATION --}}
            <p class="text-xs text-slate-400 mb-3">
                {{ $catalog->city->name }}
            </p>

            {{-- PRICE --}}
            <div class="space-y-2 mb-4">

                <div class="bg-blue-50 rounded-xl px-3 py-2">
                    <p class="text-[11px] text-slate-400">Limit</p>
                    <p class="text-blue-600 font-semibold text-sm">
                        {{ $catalog->formatted_reserve_price }}
                    </p>
                </div>

                <div class="bg-violet-50 rounded-xl px-3 py-2">
                    <p class="text-[11px] text-slate-400">Jaminan</p>
                    <p class="text-violet-600 font-semibold text-sm">
                        {{ $catalog->formatted_deposit_amount }}
                    </p>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="mt-auto flex justify-between items-center text-xs text-slate-400">
                <span>{{ $catalog->auction_date->format('d M Y') }}</span>
                <span class="text-blue-600 font-medium group-hover:underline">
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
