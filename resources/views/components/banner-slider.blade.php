@props([
    'banners',
    'variant' => 'hero'
])

@if($banners->count())

@if($variant === 'hero')
{{-- ===== HERO BANNER ===== --}}
@php $heroId = 'heroSlider' . Str::random(8); @endphp

<div 
    x-data="{
        active: 0,
        total: {{ $banners->count() }},
        interval: null,
        init() { this.play() },
        play() { this.interval = setInterval(() => this.next(), 7000) },
        pause() { clearInterval(this.interval) },
        next() { this.active = (this.active + 1) % this.total },
        prev() { this.active = (this.active - 1 + this.total) % this.total },
        go(i) { this.active = i }
    }"
    x-init="init()"
    @mouseenter="pause()"
    @mouseleave="play()"
    class="absolute inset-0 w-full h-full overflow-hidden z-0"
>
    @foreach($banners as $index => $banner)
        <div 
            class="absolute inset-0 w-full h-full transition-opacity duration-700"
            :class="active === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'"
        >
            <img 
                src="{{ asset('storage/'.$banner->image_path) }}"
                class="w-full h-full object-cover"
                alt="{{ $banner->title ?? 'Banner' }}"
            >
        </div>
    @endforeach

    <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/60 to-white/80 pointer-events-none z-20"></div>

    @if($banners->count() > 1)
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-3 z-30">
        @foreach($banners as $index => $banner)
            <button 
                @click="go({{ $index }})"
                class="h-2 rounded-full transition-all duration-500"
                :class="active === {{ $index }} 
                    ? 'w-10 bg-blue-500 shadow-lg shadow-blue-500/40' 
                    : 'w-4 bg-white/70 hover:bg-white'"
            ></button>
        @endforeach
    </div>
    @endif
</div>

@else
{{-- ===== PROMO BANNER — Vanilla JS ===== --}}
@php $sliderId = 'promo_' . Str::random(8); @endphp

<div class="relative w-full" id="{{ $sliderId }}">
    @foreach($banners as $index => $banner)
        <div class="promo-slide" style="{{ $index === 0 ? '' : 'display:none;' }}">
            <img 
                src="{{ asset('storage/'.$banner->image_path) }}"
                class="w-full h-auto block"
                alt="{{ $banner->title ?? 'Banner' }}"
            >
        </div>
    @endforeach

    @if($banners->count() > 1)
    <div class="flex justify-center gap-3 mt-3">
        @foreach($banners as $index => $banner)
            <button 
                data-index="{{ $index }}"
                class="promo-dot h-2 rounded-full transition-all duration-500 {{ $index === 0 ? 'w-10 bg-blue-500' : 'w-4 bg-gray-400' }}"
            ></button>
        @endforeach
    </div>
    @endif
</div>

<script>
(function() {
    var wrapper = document.getElementById('{{ $sliderId }}');
    if (!wrapper) return;
    var slides  = wrapper.querySelectorAll('.promo-slide');
    var dots    = wrapper.querySelectorAll('.promo-dot');
    var current = 0;

    function go(i) {
        slides[current].style.display = 'none';
        if (dots[current]) dots[current].className = 'promo-dot h-2 rounded-full transition-all duration-500 w-4 bg-gray-400';
        current = i;
        slides[current].style.display = 'block';
        if (dots[current]) dots[current].className = 'promo-dot h-2 rounded-full transition-all duration-500 w-10 bg-blue-500';
    }

    dots.forEach(function(d) {
        d.addEventListener('click', function() { go(parseInt(this.dataset.index)); });
    });

    if (slides.length > 1) {
        setInterval(function() { go((current + 1) % slides.length); }, 7000);
    }
})();
</script>

@endif
@endif