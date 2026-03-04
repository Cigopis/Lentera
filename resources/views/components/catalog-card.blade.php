@props([
    'catalog',
    'layout' => 'horizontal'
])

@php
    $visibleImages = $catalog->catalogImages
        ->where('is_visible', true)
        ->sortBy('sort_order')
        ->values();

    $thumbnail = $catalog->primaryImage
        ?? $visibleImages->first()
        ?? $catalog->catalogImages->first();

    // Jam penutupan untuk ditampilkan
    $jamLabel = $catalog->auction_time
        ? ' · ' . \Carbon\Carbon::parse($catalog->auction_time)->format('H.i') . ' WIB'
        : '';

    $deadlineStatus = $catalog->getDeadlineStatus();
    $daysLeft       = $catalog->getDaysUntilAuction();

    // Warna badge deadline
    $badgeColor = match(true) {
        $daysLeft === null || $daysLeft < 0 => 'bg-slate-100 text-slate-500',
        $daysLeft === 0                      => 'bg-red-100 text-red-600',
        $daysLeft === 1                      => 'bg-orange-100 text-orange-600',
        $daysLeft <= 7                       => 'bg-amber-100 text-amber-700',
        default                              => 'bg-emerald-100 text-emerald-600',
    };

    // Grid mode dari catalog (diambil dari DB jika ada, default main+3)
    $gridMode = $catalog->grid_mode ?? 'main+3';
@endphp

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

        {{-- ═══════════════════════════════════════
             VERTICAL — foto ikut gridMode catalog
        ════════════════════════════════════════ --}}

        <div class="relative overflow-hidden rounded-t-2xl md:rounded-t-3xl">

            {{-- ── main+3 (default) ── --}}
            @if($gridMode === 'main+3')
                <div class="grid gap-0.5 bg-slate-100" style="grid-template-columns:2fr 1fr;height:200px;">
                    {{-- Foto utama --}}
                    <div class="relative overflow-hidden">
                        <img src="{{ $thumbnail?->image_path ? asset('storage/'.$thumbnail->image_path) : asset('img/default.jpg') }}"
                             class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                             alt="{{ $catalog->title }}">
                    </div>
                    {{-- 3 foto kecil --}}
                    <div class="grid grid-rows-3 gap-0.5">
                        @for($i = 1; $i <= 3; $i++)
                            @php $img = $visibleImages->get($i); @endphp
                            <div class="relative overflow-hidden">
                                @if($img)
                                    <img src="{{ asset('storage/'.$img->image_path) }}"
                                         class="w-full h-full object-cover" alt="">
                                    @if($i === 3 && $visibleImages->count() > 4)
                                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                            <span class="text-white text-[10px] md:text-xs font-bold">
                                                +{{ $visibleImages->count() - 4 }} foto
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

            {{-- ── 2×2 ── --}}
            @elseif($gridMode === '2col')
                <div class="grid grid-cols-2 gap-0.5 bg-slate-100" style="height:200px;">
                    @for($i = 0; $i <= 3; $i++)
                        @php $img = $i === 0 ? $thumbnail : $visibleImages->get($i); @endphp
                        <div class="relative overflow-hidden">
                            @if($img)
                                <img src="{{ asset('storage/'.$img->image_path) }}"
                                     class="w-full h-full object-cover {{ $i === 0 ? 'transition duration-500 group-hover:scale-105' : '' }}"
                                     alt="">
                                @if($i === 3 && $visibleImages->count() > 4)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="text-white text-[10px] md:text-xs font-bold">
                                            +{{ $visibleImages->count() - 4 }} foto
                                        </span>
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-full bg-slate-200"></div>
                            @endif
                        </div>
                    @endfor
                </div>

            {{-- ── 3×2 ── --}}
            @elseif($gridMode === '3col')
                <div class="grid grid-cols-3 gap-0.5 bg-slate-100" style="height:200px;">
                    @for($i = 0; $i <= 5; $i++)
                        @php $img = $i === 0 ? $thumbnail : $visibleImages->get($i); @endphp
                        <div class="relative overflow-hidden">
                            @if($img)
                                <img src="{{ asset('storage/'.$img->image_path) }}"
                                     class="w-full h-full object-cover {{ $i === 0 ? 'transition duration-500 group-hover:scale-105' : '' }}"
                                     alt="">
                                @if($i === 5 && $visibleImages->count() > 6)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="text-white text-[10px] md:text-xs font-bold">
                                            +{{ $visibleImages->count() - 6 }} foto
                                        </span>
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-full bg-slate-200"></div>
                            @endif
                        </div>
                    @endfor
                </div>
            @endif

            {{-- Deadline badge — selalu tampil di atas foto --}}
            <div class="absolute top-2 right-2">
                <span class="px-1.5 py-0.5 md:px-2 md:py-1 text-[9px] md:text-[11px] font-semibold rounded-full {{ $badgeColor }}">
                    {{ $deadlineStatus }}
                </span>
            </div>

        </div>

        {{-- CONTENT --}}
        <div class="p-2 md:p-4 flex flex-col flex-1">

            <span class="text-[9px] md:text-[11px] font-semibold text-blue-600 uppercase tracking-wide mb-0.5 md:mb-1">
                {{ $catalog->category->name ?? 'Lentera' }}
            </span>

            <h3 class="text-[11px] md:text-base font-semibold text-slate-800
                       line-clamp-2 leading-snug mb-1 md:mb-2
                       group-hover:text-blue-600 transition">
                {{ $catalog->title }}
            </h3>

            <p class="text-[9px] md:text-xs text-slate-400 mb-2 md:mb-3">
                {{ $catalog->city->name }}
            </p>

            <div class="space-y-1 md:space-y-2 mb-2 md:mb-3">
                <div class="bg-blue-50 rounded-lg md:rounded-xl px-2 py-1 md:px-3 md:py-2">
                    <p class="text-[8px] md:text-[11px] text-slate-400">Limit</p>
                    <p class="text-blue-600 font-semibold text-[9px] md:text-sm leading-tight">{{ $catalog->formatted_reserve_price }}</p>
                </div>
                <div class="bg-violet-50 rounded-lg md:rounded-xl px-2 py-1 md:px-3 md:py-2">
                    <p class="text-[8px] md:text-[11px] text-slate-400">Jaminan</p>
                    <p class="text-violet-600 font-semibold text-[9px] md:text-sm leading-tight">{{ $catalog->formatted_deposit_amount }}</p>
                </div>
            </div>

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
                        {{ $catalog->auction_date->format('d M Y') }}{{ $jamLabel }}
                    </p>
                </div>
            </div>

            <div class="mt-auto flex justify-between items-center pt-1 md:pt-2 border-t border-slate-100">
                <span class="text-[8px] md:text-xs text-slate-400">{{ $deadlineStatus }}</span>
                <span class="text-[9px] md:text-xs text-blue-600 font-medium group-hover:underline">Detail →</span>
            </div>

        </div>

    @else

        {{-- ═══════════════════════════════════════
             HORIZONTAL
        ════════════════════════════════════════ --}}

        <div class="flex flex-col md:flex-row gap-4 md:gap-6 p-4 md:p-6">

            {{-- Foto — mengikuti gridMode --}}
            <div class="w-full md:w-5/12 relative overflow-hidden rounded-xl md:rounded-2xl">

                @if($gridMode === 'main+3')
                    <div class="grid gap-0.5 bg-slate-100 h-full" style="grid-template-columns:2fr 1fr;min-height:160px;">
                        <div class="relative overflow-hidden">
                            <img src="{{ $thumbnail?->image_path ? asset('storage/'.$thumbnail->image_path) : asset('img/default.jpg') }}"
                                 class="w-full h-full object-cover transition duration-700 group-hover:scale-105"
                                 alt="{{ $catalog->title }}">
                        </div>
                        <div class="grid grid-rows-3 gap-0.5">
                            @for($i = 1; $i <= 3; $i++)
                                @php $img = $visibleImages->get($i); @endphp
                                <div class="relative overflow-hidden">
                                    @if($img)
                                        <img src="{{ asset('storage/'.$img->image_path) }}"
                                             class="w-full h-full object-cover" alt="">
                                        @if($i === 3 && $visibleImages->count() > 4)
                                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">+{{ $visibleImages->count() - 4 }}</span>
                                            </div>
                                        @endif
                                    @else
                                        <div class="w-full h-full bg-slate-200"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>

                @elseif($gridMode === '2col')
                    <div class="grid grid-cols-2 gap-0.5 bg-slate-100 h-full" style="min-height:160px;">
                        @for($i = 0; $i <= 3; $i++)
                            @php $img = $i === 0 ? $thumbnail : $visibleImages->get($i); @endphp
                            <div class="relative overflow-hidden">
                                @if($img)
                                    <img src="{{ asset('storage/'.$img->image_path) }}"
                                         class="w-full h-full object-cover {{ $i === 0 ? 'transition duration-700 group-hover:scale-105' : '' }}"
                                         alt="">
                                    @if($i === 3 && $visibleImages->count() > 4)
                                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">+{{ $visibleImages->count() - 4 }}</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full bg-slate-200"></div>
                                @endif
                            </div>
                        @endfor
                    </div>

                @elseif($gridMode === '3col')
                    <div class="grid grid-cols-3 gap-0.5 bg-slate-100 h-full" style="min-height:160px;">
                        @for($i = 0; $i <= 5; $i++)
                            @php $img = $i === 0 ? $thumbnail : $visibleImages->get($i); @endphp
                            <div class="relative overflow-hidden">
                                @if($img)
                                    <img src="{{ asset('storage/'.$img->image_path) }}"
                                         class="w-full h-full object-cover {{ $i === 0 ? 'transition duration-700 group-hover:scale-105' : '' }}"
                                         alt="">
                                    @if($i === 5 && $visibleImages->count() > 6)
                                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">+{{ $visibleImages->count() - 6 }}</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full bg-slate-200"></div>
                                @endif
                            </div>
                        @endfor
                    </div>

                @else
                    {{-- Fallback: single image --}}
                    <div class="aspect-[4/3]">
                        <img src="{{ $thumbnail?->image_path ? asset('storage/'.$thumbnail->image_path) : asset('img/default.jpg') }}"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-105"
                             alt="{{ $catalog->title }}">
                    </div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent pointer-events-none"></div>
            </div>

            {{-- Info --}}
            <div class="w-full md:w-7/12 flex flex-col justify-between flex-1">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-blue-500 font-semibold text-[11px] tracking-wide uppercase">
                            {{ $catalog->category->name ?? 'Lentera' }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeColor }}">
                            {{ $deadlineStatus }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-400 mb-2">{{ $catalog->city->name }}</p>

                    <h3 class="text-base font-semibold mb-2 text-slate-800 line-clamp-2 group-hover:text-blue-600 transition">
                        {{ $catalog->title }}
                    </h3>

                    <p class="text-slate-400 text-sm mb-3 line-clamp-2 leading-relaxed">
                        {{ Str::limit(strip_tags($catalog->description), 90) }}
                    </p>

                    <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                        <div class="bg-blue-50 rounded-xl p-3">
                            <p class="text-slate-400 mb-1 text-[11px]">Limit</p>
                            <p class="text-blue-600 font-bold text-[12px]">{{ $catalog->formatted_reserve_price }}</p>
                        </div>
                        <div class="bg-violet-50 rounded-xl p-3">
                            <p class="text-slate-400 mb-1 text-[11px]">Jaminan</p>
                            <p class="text-violet-600 font-bold text-[12px]">{{ $catalog->formatted_deposit_amount }}</p>
                        </div>
                    </div>

                    {{-- Tanggal + jam --}}
                    <div class="space-y-1">
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-slate-400">Batas Setor</p>
                            <p class="text-xs font-medium text-slate-600">{{ $catalog->auction_date->subDay()->format('d M Y') }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-slate-400">Penutupan</p>
                            <p class="text-xs font-medium text-slate-600">
                                {{ $catalog->auction_date->format('d M Y') }}{{ $jamLabel }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 text-right text-blue-500 text-sm font-semibold opacity-0 group-hover:opacity-100 transition">
                    Detail →
                </div>
            </div>

        </div>

    @endif

</a>