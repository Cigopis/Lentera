@props([
    'banners',
    'variant' => 'hero' // hero | promo
])

@if($banners->count())
<div 
    x-data="bannerSlider()"
    x-init="init()"
    @mouseenter="pause()"
    @mouseleave="play()"

    class="
        {{ $variant === 'hero' 
            ? 'absolute inset-0 w-full h-full overflow-hidden z-0' 
            : 'relative w-full overflow-hidden'
        }}
    "

    {{-- 
        FIX BUG PROMO NUMPUK:
        Untuk variant promo, kita perlu container punya tinggi
        yang mengikuti gambar. Kita set tinggi via Alpine setelah
        gambar pertama load.
    --}}
    @if($variant === 'promo')
        x-ref="sliderWrap"
        style="min-height: 100px;"
    @endif
>

    @foreach($banners as $index => $banner)

        <div 
            x-show="active === {{ $index }}"

            {{-- 
                FIX: Gunakan transition yang berbeda untuk hero vs promo.
                
                Untuk PROMO: semua slide pakai position:absolute agar tidak
                numpuk satu sama lain. Hanya slide pertama yang menjadi
                "anchor" tinggi via padding-bottom trick atau js height.
                
                Untuk HERO: behavior lama tetap — absolute inset sudah benar.
            --}}
            x-transition:enter="transition-opacity duration-700 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-700 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"

            class="
                {{ $variant === 'hero'
                    ? 'absolute inset-0 w-full h-full'
                    : 'absolute inset-0 w-full'
                }}
            "

            {{-- 
                Untuk promo: slide pertama tetap di flow normal (position:relative)
                agar container punya tinggi, sisanya absolute overlay.
                Tapi karena semua pakai x-show, kita handle height via JS.
            --}}
        >

            <img 
                src="{{ asset('storage/'.$banner->image_path) }}"

                @if($variant === 'promo' && $loop->first)
                    {{-- 
                        Gambar pertama jadi penentu tinggi container.
                        Saat load, set height container = height gambar ini.
                    --}}
                    x-ref="firstImg"
                    @load="
                        $refs.sliderWrap 
                            ? $refs.sliderWrap.style.height = $el.offsetHeight + 'px'
                            : null
                    "
                @endif

                class="
                    w-full
                    {{ $variant === 'hero'
                        ? 'h-full object-cover transition-transform duration-[8000ms] ease-linear'
                        : 'w-full h-auto object-contain block'
                    }}
                "
                :class="{
                    'scale-100': active === {{ $index }} && '{{ $variant }}' === 'hero',
                    'scale-110': active !== {{ $index }} && '{{ $variant }}' === 'hero'
                }"
                alt="{{ $banner->title ?? 'Banner' }}"
                loading="{{ $loop->first ? 'eager' : 'lazy' }}"
            >

        </div>

    @endforeach


    {{-- Overlay hanya untuk hero --}}
    @if($variant === 'hero')
        <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/60 to-white/80 z-10"></div>
    @endif


    {{-- Dots --}}
    @if($banners->count() > 1)
    <div class="
        {{ $variant === 'hero' 
            ? 'absolute bottom-10 left-1/2 -translate-x-1/2 flex' 
            : 'absolute bottom-3 left-1/2 -translate-x-1/2 flex'
        }}
        gap-3 z-30
    ">
        @foreach($banners as $index => $banner)
            <button 
                @click="go({{ $index }}); resetTimer()"
                class="h-2 rounded-full transition-all duration-500"
                :class="active === {{ $index }} 
                    ? 'w-10 bg-blue-500 shadow-lg shadow-blue-500/40' 
                    : 'w-4 bg-gray-400 hover:bg-gray-600'"
                aria-label="Slide {{ $index + 1 }}"
            ></button>
        @endforeach
    </div>
    @endif


</div>

<script>
{{-- Guard agar fungsi tidak didefinisikan ulang jika component dipakai 2x di halaman yang sama --}}
if (typeof bannerSlider === 'undefined') {
    function bannerSlider() {
        return {
            active: 0,
            total: 0,      // diset saat init
            interval: null,
            delay: 7000,

            init() {
                this.total = this.$el.querySelectorAll('[x-show]').length;
                this.play();

                /* 
                    FIX PROMO NUMPUK (fallback):
                    Jika gambar sudah ter-cache oleh browser, event @load
                    tidak akan fired. Kita set tinggi container secara manual
                    setelah tick berikutnya.
                */
                this.$nextTick(() => {
                    const wrap = this.$refs.sliderWrap;
                    const img  = this.$refs.firstImg;
                    if (wrap && img && img.complete && img.naturalHeight > 0) {
                        wrap.style.height = img.offsetHeight + 'px';
                    }
                });

                /* 
                    Update tinggi container saat window di-resize
                    (gambar promo bisa responsive/berubah lebar)
                */
                if (this.$refs.sliderWrap) {
                    window.addEventListener('resize', () => {
                        const wrap = this.$refs.sliderWrap;
                        const img  = this.$refs.firstImg;
                        if (wrap && img) {
                            wrap.style.height = img.offsetHeight + 'px';
                        }
                    });
                }
            },

            play() {
                this.interval = setInterval(() => {
                    this.next();
                }, this.delay);
            },

            pause() {
                clearInterval(this.interval);
            },

            resetTimer() {
                this.pause();
                this.play();
            },

            next() {
                this.active = (this.active + 1) % this.total;
            },

            prev() {
                this.active = (this.active - 1 + this.total) % this.total;
            },

            go(index) {
                this.active = index;
            }
        }
    }
}
</script>
@endif