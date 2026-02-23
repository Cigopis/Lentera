@extends('layouts.app')

@section('content')

<style>
html, body { background-color: #f0f9ff !important; }

/* GLOBAL BACKGROUND */
body::before {
    content: "";
    position: fixed;
    inset: -30%;
    background: radial-gradient(circle at 20% 30%, #dbeafe 0%, #ede9fe 40%, #f0f9ff 80%);
    animation: morph 18s infinite alternate ease-in-out;
    z-index: -1;
    will-change: transform;
}
@keyframes morph {
    0%   { transform: scale(1)   rotate(0deg);  }
    50%  { transform: scale(1.2) rotate(8deg);  }
    100% { transform: scale(1.1) rotate(-8deg); }
}

/* SCROLL REVEAL */
.reveal {
    opacity: 0;
    filter: blur(20px);
    transform: translateY(80px);
    transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.reveal.active {
    opacity: 1;
    filter: blur(0);
    transform: translateY(0);
}

/* MAGNETIC */
.magnetic { transition: transform 0.2s ease-out; }

/* ============================================
   STACK SCROLL — MORNING LIGHT
   ============================================ */
.stackscroll-outer {
    position: relative;
    height: 400vh;
    background: #fff;
}
.stackscroll-sticky {
    position: sticky;
    top: 0;
    height: 100vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.stackscroll-bg {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 30% 20%, #bfdbfe 0%, transparent 55%),
        radial-gradient(ellipse at 70% 80%, #ddd6fe 0%, transparent 55%),
        linear-gradient(to bottom, #f0f9ff 0%, #ffffff 100%);
    z-index: 0;
}
.stackscroll-rays {
    position: absolute;
    inset: 0;
    z-index: 1;
    overflow: hidden;
    opacity: 0.12;
    background: repeating-conic-gradient(
        from 0deg at 50% -20%,
        #93c5fd 0deg 6deg,
        transparent 6deg 18deg
    );
    animation: raysRotate 60s linear infinite;
}
@keyframes raysRotate {
    from { transform: rotate(0deg);   }
    to   { transform: rotate(360deg); }
}
.stackscroll-dust {
    position: absolute;
    inset: 0;
    z-index: 2;
    background-image:
        radial-gradient(circle, rgba(59,130,246,0.35) 1px, transparent 1px),
        radial-gradient(circle, rgba(139,92,246,0.2)  1px, transparent 1px);
    background-size: 60px 60px, 100px 100px;
    background-position: 0 0, 30px 30px;
    opacity: 0.4;
    animation: dustFloat 40s linear infinite;
}
@keyframes dustFloat {
    from { transform: translateY(0);      }
    to   { transform: translateY(-200px); }
}
.stackscroll-shoot {
    position: absolute;
    top: 20%;
    left: -200px;
    width: 300px;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(59,130,246,0.6), transparent);
    opacity: 0;
    z-index: 3;
    animation: shoot 12s ease-in-out infinite;
}
@keyframes shoot {
    0%   { transform: translate(0,0) rotate(15deg);         opacity: 0; }
    5%   {                                                   opacity: 1; }
    40%  { transform: translate(130vw, 80px) rotate(15deg); opacity: 0; }
    100% {                                                   opacity: 0; }
}

/* Progress bar */
.stackscroll-progress {
    position: absolute;
    left: clamp(16px, 3vw, 48px);
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 200px;
    background: rgba(59,130,246,0.12);
    border-radius: 99px;
    z-index: 30;
}
.stackscroll-progress-fill {
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 0%;
    background: linear-gradient(to bottom, #3b82f6, #6366f1);
    border-radius: 99px;
    transition: height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 0 12px rgba(59,130,246,0.4);
}
.stackscroll-dots {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    gap: 60px;
    top: 0;
    height: 100%;
    pointer-events: none;
}
.stackscroll-dot {
    width: 9px; height: 9px;
    background: rgba(59,130,246,0.2);
    border-radius: 50%;
    margin-left: -3px;
    transition: all 0.5s ease;
    border: 1.5px solid transparent;
    flex-shrink: 0;
}
.stackscroll-dot.active {
    background: #3b82f6;
    border-color: #93c5fd;
    box-shadow: 0 0 12px rgba(59,130,246,0.5);
}

/* Section header */
.stackscroll-section-header {
    position: absolute;
    top: clamp(32px, 5vh, 60px);
    left: clamp(48px, 6vw, 100px);
    z-index: 25;
    text-align: left;
}
.stackscroll-section-eyebrow {
    font-size: 11px;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: #3b82f6;
    margin-bottom: 8px;
    font-weight: 600;
}
.stackscroll-section-title {
    font-size: clamp(22px, 3.5vw, 40px);
    font-weight: 800;
    color: #1e293b;
    line-height: 1.15;
    letter-spacing: -0.02em;
}

/* Content */
.stackscroll-content {
    position: relative;
    z-index: 20;
    width: 100%;
    max-width: 680px;
    padding: 0 24px;
}
.stackscroll-step {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0 24px;
    opacity: 0;
    transform: translateY(60px) scale(0.96);
    filter: blur(8px);
    transition:
        opacity   0.9s cubic-bezier(0.16, 1, 0.3, 1),
        transform 0.9s cubic-bezier(0.16, 1, 0.3, 1),
        filter    0.9s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
}
.stackscroll-step.active {
    opacity: 1;
    transform: translateY(0) scale(1);
    filter: blur(0);
    pointer-events: auto;
}
.stackscroll-step.exit-up {
    opacity: 0;
    transform: translateY(-60px) scale(0.96);
    filter: blur(8px);
}

/* Number */
.stackscroll-num {
    font-size: clamp(80px, 15vw, 140px);
    font-weight: 800;
    line-height: 1;
    background: linear-gradient(135deg, #2563eb, #7c3aed, #0ea5e9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.04em;
    position: relative;
    filter: drop-shadow(0 4px 24px rgba(59,130,246,0.18));
}
.stackscroll-num::after {
    content: attr(data-num);
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #3b82f6, #818cf8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: blur(24px);
    z-index: -1;
    opacity: 0.5;
}

/* Divider */
.stackscroll-divider {
    width: 1px;
    height: 60px;
    background: linear-gradient(to bottom, #3b82f6, transparent);
    margin: 12px auto 28px;
    position: relative;
}
.stackscroll-divider::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 6px; height: 6px;
    background: #3b82f6;
    border-radius: 50%;
    box-shadow: 0 0 14px rgba(59,130,246,0.5);
}

/* Title & desc */
.stackscroll-title {
    font-size: clamp(22px, 4vw, 36px);
    font-weight: 700;
    color: #1e293b;
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin-bottom: 16px;
}
.stackscroll-desc {
    font-size: clamp(14px, 2vw, 17px);
    color: #64748b;
    line-height: 1.75;
    max-width: 480px;
}

/* Badge */
.stackscroll-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    border-radius: 99px;
    background: rgba(59,130,246,0.08);
    border: 1px solid rgba(59,130,246,0.2);
    color: #2563eb;
    font-size: 12px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 20px;
}

/* Glow */
.stackscroll-glow {
    position: absolute;
    width: 700px; height: 700px;
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
    filter: blur(140px);
    opacity: 0;
    transition: opacity 1.2s ease;
    left: 50%; top: 50%;
    transform: translate(-50%, -50%);
}
.stackscroll-glow.s1 { background: #bfdbfe; }
.stackscroll-glow.s2 { background: #ddd6fe; }
.stackscroll-glow.s3 { background: #bae6fd; }
.stackscroll-glow.active { opacity: 0.8; }

/* Scroll hint */
.stackscroll-hint {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    opacity: 0.4;
    animation: hintBob 2s ease-in-out infinite;
    transition: opacity 0.5s;
    z-index: 30;
}
.stackscroll-hint.hidden { opacity: 0; pointer-events: none; }
@keyframes hintBob {
    0%, 100% { transform: translateX(-50%) translateY(0);  }
    50%       { transform: translateX(-50%) translateY(6px); }
}
.stackscroll-hint span {
    font-size: 10px;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: #64748b;
}
.stackscroll-hint svg {
    width: 20px; height: 20px;
    stroke: #64748b;
}

/* Hero text */
.hero-text h1 { color: #0f172a; }
.hero-text p  { color: #475569; }

/* Catalog section */
.catalog-section          { background: #f8fafc; }
.catalog-section h2       { color: #0f172a; }
.catalog-section p        { color: #64748b; }

/* ============================================
   PROMO BANNER SLIDER FIX
   — semua slide pakai position:absolute agar
     tidak numpuk ketika transisi
   ============================================ */
.promo-slider-wrap {
    position: relative;
    width: 100%;
    overflow: hidden;
    /* tinggi akan diset via JS sesuai banner pertama */
}
.promo-slider-wrap .promo-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.6s ease;
    pointer-events: none;
}
.promo-slider-wrap .promo-slide.active {
    position: relative; /* hanya slide aktif yg ambil ruang */
    opacity: 1;
    pointer-events: auto;
}
</style>

<script>
/* =====================================================
   FIX BUG 1 — scroll auto ke atas
   Masalah asal: scrollRestoration=manual + scrollTo(0)
   dipanggil SETIAP load, bukan hanya bfcache.
   Fix: scrollTo(0) HANYA saat bfcache (e.persisted).
   ===================================================== */
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'auto'; /* biarkan browser handle normal */
}

window.addEventListener('pageshow', function(e) {
    /* Hanya reset scroll saat halaman dipulihkan dari bfcache */
    if (e.persisted) {
        window.scrollTo({ top: 0, behavior: 'instant' });
        /* Trigger scroll event SETELAH posisi benar-benar di atas */
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                window.dispatchEvent(new Event('scroll'));
            });
        });
    }
});

/* HAPUS: if (!window.location.hash) scrollTo(0) — ini penyebab bug scroll ke atas */

document.addEventListener("DOMContentLoaded", function() {

    /* ===== Scroll Reveal ===== */
    var reveals = document.querySelectorAll(".reveal");
    var revealObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
            } else {
                entry.target.classList.remove("active");
            }
        });
    }, { threshold: 0.15 });
    reveals.forEach(function(el) { revealObserver.observe(el); });

    /* ===== Magnetic Hover ===== */
    document.querySelectorAll(".magnetic").forEach(function(btn) {
        btn.addEventListener("mousemove", function(e) {
            var rect = btn.getBoundingClientRect();
            var x = e.clientX - rect.left - rect.width  / 2;
            var y = e.clientY - rect.top  - rect.height / 2;
            btn.style.transform = "translate(" + (x * 0.2) + "px, " + (y * 0.2) + "px)";
        });
        btn.addEventListener("mouseleave", function() {
            btn.style.transform = "translate(0,0)";
        });
    });

    /* ===== Parallax ===== */
    window.addEventListener("scroll", function() {
        var offset = window.scrollY;
        document.querySelectorAll("[data-depth]").forEach(function(el) {
            el.style.transform = "translateY(" + (offset * el.dataset.depth) + "px)";
        });
    }, { passive: true });

    /* ===== Stack Scroll ===== */
    (function() {
        var outer = document.querySelector('.stackscroll-outer');
        if (!outer) return;

        var steps = document.querySelectorAll('.stackscroll-step');
        var fill  = document.getElementById('ss-fill');
        var dots  = document.querySelectorAll('[data-dot]');
        var hint  = document.getElementById('ss-hint');
        var glow  = document.getElementById('ss-glow');

        var TOTAL      = steps.length;
        var current    = -1;
        var glowColors = ['s1','s2','s3'];

        function setStep(idx) {
            if (idx === current) return;
            steps.forEach(function(el, i) {
                if (i === idx) {
                    el.classList.remove('exit-up');
                    el.classList.add('active');
                } else if (i < idx) {
                    el.classList.remove('active');
                    el.classList.add('exit-up');
                } else {
                    el.classList.remove('active','exit-up');
                }
            });
            dots.forEach(function(dot, i) {
                dot.classList.toggle('active', i <= idx);
            });
            if (fill) fill.style.height = ((idx + 1) / TOTAL * 100) + '%';
            if (glow) glow.className = 'stackscroll-glow ' + (glowColors[idx] || 's1') + ' active';
            if (hint) hint.classList.toggle('hidden', idx > 0);
            current = idx;
        }

        function onScroll() {
            var rect       = outer.getBoundingClientRect();
            var outerH     = outer.offsetHeight;
            var vpH        = window.innerHeight;
            var scrolled   = -rect.top;
            var scrollable = outerH - vpH;

            if (scrolled < 0 || scrolled > scrollable) return;

            var progress  = Math.min(Math.max(scrolled / scrollable, 0), 1);
            var stepIndex = Math.min(Math.floor(progress * TOTAL), TOTAL - 1);
            setStep(stepIndex);
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    })();

    /* =====================================================
       FIX BUG 2 — Banner numpuk saat transisi
       Cara kerja:
       - Semua slide pakai position:absolute (opacity:0)
       - Slide aktif diubah ke position:relative (opacity:1)
         agar parent punya tinggi yang benar
       - Transisi opacity smooth, tidak ada layout jump
       ===================================================== */
    document.querySelectorAll('.promo-slider-wrap').forEach(function(wrap) {
        var slides = wrap.querySelectorAll('.promo-slide');
        if (slides.length <= 1) return;

        var current = 0;
        var isTransitioning = false;

        function goTo(next) {
            if (isTransitioning || next === current) return;
            isTransitioning = true;

            var prev = current;
            current  = next;

            /* 1. Buat slide baru absolute+opacity:0 dulu (pre-position) */
            slides[next].style.position = 'absolute';
            slides[next].style.opacity  = '0';
            slides[next].classList.add('active');

            /* 2. Fade in slide baru */
            requestAnimationFrame(function() {
                slides[next].style.opacity = '1';

                /* 3. Setelah transisi selesai, baru ganti ke relative */
                setTimeout(function() {
                    /* Slide lama: sembunyikan */
                    slides[prev].style.position = 'absolute';
                    slides[prev].style.opacity  = '0';
                    slides[prev].classList.remove('active');

                    /* Slide baru: ambil ruang normal */
                    slides[next].style.position = 'relative';

                    isTransitioning = false;
                }, 650); /* harus >= durasi transisi CSS (0.6s) */
            });
        }

        /* Auto-play */
        var timer = setInterval(function() {
            goTo((current + 1) % slides.length);
        }, 4000);

        /* Init: pastikan slide pertama relative, sisanya absolute */
        slides.forEach(function(slide, i) {
            if (i === 0) {
                slide.style.position = 'relative';
                slide.style.opacity  = '1';
                slide.classList.add('active');
            } else {
                slide.style.position = 'absolute';
                slide.style.opacity  = '0';
                slide.classList.remove('active');
            }
        });

        /* Pause on hover */
        wrap.addEventListener('mouseenter', function() { clearInterval(timer); });
        wrap.addEventListener('mouseleave', function() {
            timer = setInterval(function() {
                goTo((current + 1) % slides.length);
            }, 4000);
        });
    });

});
</script>


{{-- ===================== HERO ==================== --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">

    @if($heroBanners->isNotEmpty())
        <x-banner-slider :banners="$heroBanners" variant="hero" />
    @endif

    <div class="absolute inset-0 pointer-events-none z-10">
        <div data-depth="0.2"
             class="absolute -top-40 -left-40 w-[600px] h-[600px]
                    bg-blue-200 rounded-full blur-[200px] opacity-60"></div>
        <div data-depth="0.4"
             class="absolute bottom-0 right-0 w-[500px] h-[500px]
                    bg-violet-200 rounded-full blur-[180px] opacity-50"></div>
    </div>

    <div class="hero-text relative z-20 text-center px-6"
         x-data
         x-init="$el.classList.add('active')"
         x-transition:enter="transition duration-1000 ease-out"
         x-transition:enter-start="opacity-0 translate-y-10 blur-xl"
         x-transition:enter-end="opacity-100 translate-y-0 blur-0">
        <h1 class="text-5xl md:text-7xl font-bold tracking-tight leading-tight">
            E-Katalog Lentera Kertajaya
        </h1>
        <p class="mt-6 text-lg max-w-xl mx-auto">
            Pusat informasi aset lelang terpadu yang membantu Anda melihat peluang dengan lebih jelas dan terarah.
        </p>
        <div class="mt-10">
            <a href="{{ route('katalog.index') }}"
               class="magnetic inline-block px-10 py-4 rounded-full
                      bg-blue-600 text-white font-semibold
                      shadow-lg shadow-blue-400/30
                      hover:scale-105 transition hover:bg-blue-700">
                Cari Katalog
            </a>
        </div>
    </div>

</section>


{{-- ===================== STACK SCROLL ==================== --}}
<section class="stackscroll-outer mb-20" id="cara-daftar">
    <div class="stackscroll-sticky">

        <div class="stackscroll-bg"></div>
        <div class="stackscroll-rays"></div>
        <div class="stackscroll-dust"></div>
        <div class="stackscroll-shoot"></div>

        <div class="stackscroll-glow s1 active" id="ss-glow"></div>

        <div class="stackscroll-section-header pt-14">
            <p class="stackscroll-section-eyebrow">Cara Kerja</p>
            <h2 class="stackscroll-section-title">Panduan Alur Lentera</h2>
        </div>

        {{-- PROGRESS BAR --}}
        <div class="stackscroll-progress">
            <div class="stackscroll-progress-fill" id="ss-fill"></div>

            <div class="stackscroll-dots">
                @foreach($guideSteps as $index => $step)
                    <div class="stackscroll-dot {{ $loop->first ? 'active' : '' }}"
                         data-dot="{{ $index }}">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="stackscroll-content" style="position:relative; height:340px;">

            @foreach($guideSteps as $index => $step)
                <div class="stackscroll-step {{ $loop->first ? 'active' : '' }}"
                     data-step="{{ $index }}">

                    <div class="stackscroll-badge">
                        Langkah {{ $step->step_number }}
                    </div>

                    <div class="stackscroll-num"
                         data-num="{{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}">
                        {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="stackscroll-divider"></div>

                    <h3 class="stackscroll-title">
                        {{ $step->title }}
                    </h3>

                    <p class="stackscroll-desc">
                        {!! $step->description !!}
                    </p>

                </div>
            @endforeach

        </div>

        <div class="stackscroll-hint" id="ss-hint">
            <span>Scroll</span>
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </div>

    </div>
</section>


{{-- ===================== KATALOG ==================== --}}
<section class="catalog-section max-w-7xl mx-auto px-6 md:px-12 py-20">

    {{-- ================= HEADER ================= --}}
    <div class="mb-16">
        <h2 class="text-3xl md:text-4xl font-semibold mb-6 reveal">
            Pilihan Kategori
        </h2>

        <div class="flex flex-wrap gap-3 reveal">

            {{-- Semua --}}
            <a href="{{ url()->current() }}"
               class="px-5 py-2 rounded-full text-sm font-medium transition
               {{ request('kategori')
                   ? 'bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white'
                   : 'bg-blue-600 text-white shadow-md shadow-blue-400/30' }}">
                Semua
            </a>

            {{-- Loop kategori --}}
            @foreach ($categories as $item)
                <a href="{{ request()->fullUrlWithQuery(['kategori' => $item->slug]) }}"
                   class="px-5 py-2 rounded-full text-sm font-medium transition
                   {{ request('kategori') == $item->slug
                       ? 'bg-blue-600 text-white shadow-md shadow-blue-400/30'
                       : 'bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white' }}">
                    {{ $item->name }}
                </a>
            @endforeach

        </div>
    </div>


    {{-- ================= BANNER PROMO FULL WIDTH ================= --}}
    {{--
        FIX BUG 2: Bungkus banner promo dengan .promo-slider-wrap
        agar JS slider di atas bisa mengontrol transisi dengan benar.
        Pastikan x-banner-slider component menambahkan class .promo-slide
        ke setiap slide item-nya, atau gunakan wrapper di bawah ini.
    --}}
    <div class="relative w-screen left-1/2 -translate-x-1/2 mb-20">
        <div class="promo-slider-wrap">
            <x-banner-slider :banners="$promoBanners" variant="promo" />
        </div>
    </div>


    {{-- ================= HEADER KATALOG ================= --}}
    @php
        $activeCategory = request('kategori')
            ? $categories->firstWhere('slug', request('kategori'))
            : null;
    @endphp

    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12 reveal">
        <div>
            <h2 class="text-3xl md:text-4xl font-semibold mb-3">
                Daftar Lot Lelang
            </h2>
            <p class="text-slate-500">
                Menampilkan kategori:
                <span class="font-semibold text-blue-600">
                    {{ $activeCategory?->name ?? 'Semua' }}
                </span>
            </p>
        </div>
    </div>


    {{-- ================= GRID KATALOG ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">

        @forelse($catalogs as $catalog)
            <div class="reveal">
                <x-catalog-card :catalog="$catalog" />
            </div>
        @empty
            <div class="col-span-full text-center py-24 text-slate-400">
                Belum tersedia katalog lelang
            </div>
        @endforelse

    </div>


    {{-- ================= BUTTON LIHAT LEBIH BANYAK ================= --}}
    @if($totalCatalogs > 4)
        <div class="mt-14 text-center">
            <a href="{{ route('katalog.index', request()->only('kategori')) }}"
               class="group inline-flex items-center gap-3 px-8 py-3 rounded-full
                      bg-gradient-to-r from-blue-600 to-blue-500
                      text-white font-medium
                      hover:scale-105 hover:shadow-xl hover:shadow-blue-500/30
                      transition-all duration-300">

                Lihat Lebih Banyak

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    @endif

</section>

@endsection