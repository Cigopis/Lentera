@extends('layouts.app')
@section('content')

<style>
html, body { background-color: #f0f9ff !important; }

/* Sembunyikan footer khusus halaman ini */
footer { display: none !important; }

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

.reveal {
    opacity: 0;
    filter: blur(20px);
    transform: translateY(60px);
    transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.reveal.active {
    opacity: 1;
    filter: blur(0);
    transform: translateY(0);
}

/* ---- Hero ---- */
.help-hero {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow: visible;
    padding: 80px 24px 100px;
}
.help-hero-bg {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 30% 30%, #bfdbfe 0%, transparent 55%),
        radial-gradient(ellipse at 70% 70%, #ddd6fe 0%, transparent 55%),
        linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
    z-index: 0;
    border-radius: 0 0 40px 40px;
}
.help-hero-rays {
    position: absolute;
    inset: 0;
    z-index: 1;
    opacity: 0.08;
    background: repeating-conic-gradient(
        from 0deg at 50% -30%,
        #93c5fd 0deg 6deg,
        transparent 6deg 18deg
    );
    animation: raysRotate 80s linear infinite;
}
@keyframes raysRotate {
    from { transform: rotate(0deg);   }
    to   { transform: rotate(360deg); }
}
.help-hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    max-width: 680px;
    width: 100%;
}
.help-hero h1 {
    font-size: clamp(32px, 6vw, 64px);
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.03em;
    line-height: 1.1;
    margin-bottom: 16px;
}
.help-hero p {
    font-size: clamp(14px, 2vw, 18px);
    color: #475569;
    margin-bottom: 36px;
}

/* Quick action cards */
.quick-actions-wrapper {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 1280px;
    padding: 0 24px 60px;
    margin: -60px auto 0;
}

/* Search bar */
.help-search {
    position: relative;
    max-width: 560px;
    margin: 0 auto;
}
.help-search input {
    width: 100%;
    padding: 16px 56px 16px 24px;
    border-radius: 99px;
    border: 1.5px solid rgba(59,130,246,0.2);
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(12px);
    font-size: 15px;
    color: #1e293b;
    box-shadow: 0 8px 32px rgba(59,130,246,0.1);
    outline: none;
    transition: all 0.3s ease;
}
.help-search input:focus {
    border-color: #3b82f6;
    box-shadow: 0 8px 32px rgba(59,130,246,0.2), 0 0 0 4px rgba(59,130,246,0.08);
}
.help-search button {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    width: 42px; height: 42px;
    border-radius: 50%;
    background: #3b82f6;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}
.help-search button:hover { background: #2563eb; }
.help-search button svg { stroke: white; width: 18px; height: 18px; }

/* Section title */
.section-eyebrow {
    font-size: 11px;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: #3b82f6;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
}
.section-heading {
    font-size: clamp(24px, 4vw, 36px);
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 40px;
}

/* ---- CTA (desain mengikuti referensi temanmu) ---- */
.help-cta {
    background:
        radial-gradient(ellipse at 15% 50%, rgba(191,219,254,0.55) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 50%, rgba(221,214,254,0.55) 0%, transparent 55%),
        linear-gradient(135deg, #f8faff 0%, #f4f0ff 100%);
    border: 1.5px solid rgba(226,232,240,0.9);
    border-radius: 24px;
    padding: 64px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 32px rgba(59,130,246,0.06);
}
.help-cta .section-eyebrow {
    color: #94a3b8;
    letter-spacing: 0.22em;
}
.help-cta h2 {
    font-size: clamp(24px, 4vw, 40px);
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 14px;
}
.help-cta > p {
    color: #64748b;
    font-size: 15px;
    max-width: 500px;
    margin: 0 auto 36px;
    line-height: 1.7;
}
.cta-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 36px;
    border-radius: 99px;
    background: #3b82f6;
    color: white !important;
    font-size: 15px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.3s ease;
    box-shadow: 0 8px 28px rgba(59,130,246,0.38);
}
.cta-btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(59,130,246,0.45);
    color: white !important;
    text-decoration: none !important;
}
.cta-btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 36px;
    border-radius: 99px;
    background: white;
    color: #374151 !important;
    font-size: 15px;
    font-weight: 600;
    border: 1.5px solid #e2e8f0;
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.cta-btn-secondary:hover {
    border-color: #bfdbfe;
    box-shadow: 0 8px 24px rgba(59,130,246,0.1);
    transform: translateY(-2px);
    color: #374151 !important;
    text-decoration: none !important;
}
</style>

{{-- ===================== HERO ==================== --}}
<div class="help-hero">
    <div class="help-hero-bg"></div>
    <div class="help-hero-rays"></div>

    <div class="help-hero-content">
        <p class="section-eyebrow" style="margin-bottom:12px;">Support Center</p>
        <h1>Pusat Bantuan</h1>
        <p>Panduan lengkap menggunakan katalog lelang BRI Kertajaya</p>

        <div class="help-search">
            <input type="text" id="searchInput" placeholder="Cari bantuan tentang katalog lelang...">
            <button>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </div>

        <!-- Search Results -->
        <div id="searchResults" class="hidden mt-4 bg-white rounded-xl shadow-xl p-4 text-left max-h-96 overflow-y-auto">
            <p class="text-sm text-gray-500 mb-2">Hasil Pencarian:</p>
            <div id="searchResultsList"></div>
        </div>
    </div>
</div>

{{-- ===================== QUICK ACTIONS ==================== --}}
<div class="quick-actions-wrapper">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="quick-action-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 text-center group cursor-pointer" data-modal="modal1">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 transition-colors">
                <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Cara Cari Katalog</h3>
            <p class="text-sm text-gray-600">Filter & pencarian katalog</p>
        </div>

        <div class="quick-action-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 text-center group cursor-pointer" data-modal="modal2">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition-colors">
                <svg class="w-8 h-8 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Detail Katalog</h3>
            <p class="text-sm text-gray-600">Informasi properti lelang</p>
        </div>

        <div class="quick-action-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 text-center group cursor-pointer" data-modal="modal3">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition-colors">
                <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Ke Website Lelang</h3>
            <p class="text-sm text-gray-600">Akses situs resmi lelang</p>
        </div>

        <div class="quick-action-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 text-center group cursor-pointer" data-modal="modal4">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-600 transition-colors">
                <svg class="w-8 h-8 text-orange-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Hubungi Kami</h3>
            <p class="text-sm text-gray-600">Info lebih lanjut</p>
        </div>
    </div>
</div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <!-- FAQ Section -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Temukan jawaban dari pertanyaan umum seputar lelang properti BRI Kertajaya</p>
            </div>

            <div class="max-w-4xl mx-auto space-y-4">
                <!-- FAQ Item 1 -->
                <div class="faq-item group">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-200 overflow-hidden">
                        <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Apa itu Lentera?</span>
                            <svg class="faq-icon w-6 h-6 text-blue-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-blue-500">
                                <p class="text-gray-700 leading-relaxed">Lentera adalah platform informasi yang menampilkan daftar properti (rumah, ruko, tanah, dll) yang akan dilelang oleh BRI Kantor Cabang Kertajaya. Website ini berfungsi sebagai media promosi dan informasi, Pengelompokan aset lelang yang hanya di selenggarakan oleh BRI Kertajaya.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item group">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-green-200 overflow-hidden">
                        <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Bagaimana cara mencari properti berdasarkan lokasi?</span>
                            <svg class="faq-icon w-6 h-6 text-green-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-green-500">
                                <p class="text-gray-700 leading-relaxed">Gunakan fitur filter di navigasi bar. Anda bisa memilih kota/kabupaten, atau menggunakan kolom pencarian untuk mencari lokasi spesifik seperti nama kecamatan atau jalan. Filter juga tersedia untuk tipe properti dan range harga limit.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item group">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-purple-200 overflow-hidden">
                        <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Apakah saya bisa mengikuti lelang langsung di website ini?</span>
                            <svg class="faq-icon w-6 h-6 text-purple-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-purple-500">
                                <p class="text-gray-700 leading-relaxed">Tidak, website ini hanya sebagai katalog informasi. Untuk mengikuti lelang, Anda harus klik tombol "Ikuti Lelang" pada detail properti yang akan mengarahkan Anda ke website resmi lelang BRI atau platform lelang resmi seperti infolelang.bri.co.id</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item group">
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-orange-200 overflow-hidden">
                        <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Apa itu harga limit lelang?</span>
                            <svg class="faq-icon w-6 h-6 text-orange-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-orange-500">
                                <p class="text-gray-700 leading-relaxed">Harga limit adalah harga terendah yang ditetapkan oleh penjual untuk properti yang dilelang. Penawaran dalam lelang harus dimulai dari harga limit atau lebih tinggi. Harga limit biasanya sudah memperhitungkan nilai agunan dan kondisi properti.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item group">
                    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-cyan-200 overflow-hidden">
                        <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Bagaimana cara menghubungi BRI Kertajaya untuk info lebih lanjut?</span>
                            <svg class="faq-icon w-6 h-6 text-cyan-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-cyan-500">
                                <p class="text-gray-700 leading-relaxed">Anda dapat menghubungi BRI Kertajaya melalui nomor telepon yang tertera di halaman Kontak Kami, atau datang langsung ke kantor BRI Cabang Kertajaya. Tim kami siap memberikan informasi detail mengenai properti dan proses lelang.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="faq-item group">
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-red-200 overflow-hidden">
                        <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </div>
                            <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Seberapa sering katalog diupdate?</span>
                            <svg class="faq-icon w-6 h-6 text-red-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-red-500">
                    <p class="text-gray-700 leading-relaxed">Katalog lelang diupdate secara berkala setiap ada jadwal lelang baru atau perubahan informasi properti. Kami merekomendasikan untuk mengecek website secara rutin</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional FAQs -->
                <div id="additionalFAQs" class="hidden space-y-4">
                    <!-- FAQ Item 7 -->
                    <div class="faq-item group">
                        <div class="bg-gradient-to-r from-indigo-50 to-violet-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-indigo-200 overflow-hidden">
                            <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Apa persyaratan untuk mengikuti lelang?</span>
                                <svg class="faq-icon w-6 h-6 text-indigo-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-content hidden px-6 pb-5">
                                <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-indigo-500">
                                    <p class="text-gray-700 leading-relaxed">Persyaratan umum meliputi: KTP asli dan fotokopi, NPWP, menyetor uang jaminan sesuai ketentuan (biasanya 20% dari harga limit), dan mengisi formulir pendaftaran lelang.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 8 -->
                    <div class="faq-item group">
                        <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-teal-200 overflow-hidden">
                            <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Berapa biaya yang harus dikeluarkan selain harga properti?</span>
                                <svg class="faq-icon w-6 h-6 text-teal-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-content hidden px-6 pb-5">
                                <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-teal-500">
                                    <p class="text-gray-700 leading-relaxed">Biaya tambahan meliputi: Bea Lelang (1-2%), PPh Final (2.5%), BPHTB, biaya balik nama sertifikat, dan biaya notaris. Total biaya tambahan berkisar 5-7% dari harga properti.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 9 -->
                    <div class="faq-item group">
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-yellow-200 overflow-hidden">
                            <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </div>
                                <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Apakah properti lelang bisa dikunjungi sebelum lelang?</span>
                                <svg class="faq-icon w-6 h-6 text-yellow-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-content hidden px-6 pb-5">
                                <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-yellow-500">
                                    <p class="text-gray-700 leading-relaxed">Ya, calon pembeli sangat dianjurkan untuk melakukan survey lokasi sebelum mengikuti lelang. Anda dapat menghubungi BRI Kertajaya untuk mengatur jadwal kunjungan properti.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 10 -->
                    <div class="faq-item group">
                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-pink-200 overflow-hidden">
                            <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                </div>
                                <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Bagaimana jika saya memenangkan lelang?</span>
                                <svg class="faq-icon w-6 h-6 text-pink-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-content hidden px-6 pb-5">
                                <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-pink-500">
                                    <p class="text-gray-700 leading-relaxed">Setelah dinyatakan sebagai pemenang, Anda harus: 1) Menandatangani Risalah Lelang, 2) Melunasi sisa pembayaran (biasanya 1-7 hari), 3) Mengurus balik nama sertifikat melalui notaris, 4) Mengambil kunci dan dokumen properti setelah administrasi selesai.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 11 -->
                    <div class="faq-item group">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-emerald-200 overflow-hidden">
                            <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Apakah properti lelang bisa dibatalkan?</span>
                                <svg class="faq-icon w-6 h-6 text-emerald-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-content hidden px-6 pb-5">
                                <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-emerald-500">
                                    <p class="text-gray-700 leading-relaxed">Ya, lelang dapat dibatalkan jika debitur melunasi hutang sebelum lelang, ada gugatan hukum, atau terdapat permasalahan administratif. Uang jaminan akan dikembalikan penuh jika terjadi pembatalan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 12 -->
                    <div class="faq-item group">
                        <div class="bg-gradient-to-r from-lime-50 to-green-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-lime-200 overflow-hidden">
                            <button class="faq-button w-full px-6 py-5 text-left flex items-center gap-4 hover:bg-white/50 transition-colors">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-lime-500 to-lime-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                </div>
                                <span class="flex-1 font-bold text-gray-800 pr-4 text-lg">Bagaimana jika tidak ada yang menawar pada lelang pertama?</span>
                                <svg class="faq-icon w-6 h-6 text-lime-600 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="faq-content hidden px-6 pb-5">
                                <div class="ml-14 p-4 bg-white rounded-lg border-l-4 border-lime-500">
                                    <p class="text-gray-700 leading-relaxed">Jika lelang pertama tidak ada penawar, akan dilakukan lelang ulang dengan harga limit yang mungkin disesuaikan. Properti dapat dilelang beberapa kali sampai mendapatkan penawar yang sesuai.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Show All FAQ Button -->
            <div class="text-center mt-10 text-blue-600">
                <button id="showAllFAQBtn" class="group inline-flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Lihat semua FAQ</span>
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-y-1" id="showAllIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 pb-28">
        <div class="help-cta reveal">
            <p class="section-eyebrow" style="margin-bottom:12px;">Kontak</p>
            <h2>Butuh Informasi Lebih Detail?</h2>
            <p>Tim BRI Kertajaya siap membantu Anda dengan informasi properti lelang, jadwal, dan proses lelang. Hubungi kami untuk konsultasi gratis.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a
                    href="https://wa.me/6285731599031?text=Halo%20BRI%20Kertajaya%2C%20saya%20ingin%20bertanya%20mengenai%20katalog%20lelang%20properti."
                    target="_blank"
                    rel="noopener noreferrer"
                    class="cta-btn-primary"
                >
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Hubungi BRI Kertajaya
                </a>
                <a
                    href="https://maps.app.goo.gl/GpMAVV2BcY4vCeP8A"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="cta-btn-secondary"
                >
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="color:#ef4444;">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Lihat Lokasi Kantor
                </a>
            </div>
        </div>
    </div>

    <!-- Modal 1: Cara Cari Katalog -->
    <div id="modal1" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold">Cara Cari Katalog</h3>
                    </div>
                    <button class="close-modal text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <div class="bg-blue-50 rounded-xl p-4 border-l-4 border-blue-600">
                    <p class="text-gray-700 leading-relaxed"><strong class="text-blue-900">Filter & Pencarian Katalog</strong> memudahkan Anda menemukan properti lelang yang sesuai.</p>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-4"><div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div><div><h4 class="font-semibold text-gray-800 mb-2">Gunakan Filter Kategori</h4><p class="text-gray-600">Pilih kategori properti: Rumah, Tanah, Ruko, Gudang, atau Mobil.</p></div></div>
                    <div class="flex gap-4"><div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">2</div><div><h4 class="font-semibold text-gray-800 mb-2">Filter Berdasarkan Lokasi</h4><p class="text-gray-600">Gunakan dropdown lokasi untuk memilih kota atau kabupaten.</p></div></div>
                    <div class="flex gap-4"><div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">3</div><div><h4 class="font-semibold text-gray-800 mb-2">Filter Harga</h4><p class="text-gray-600">Atur range harga limit sesuai budget Anda.</p></div></div>
                    <div class="flex gap-4"><div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">4</div><div><h4 class="font-semibold text-gray-800 mb-2">Cari dengan Kata Kunci</h4><p class="text-gray-600">Ketik kata kunci seperti alamat, nomor SHM, atau nama daerah.</p></div></div>
                    <div class="flex gap-4"><div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">5</div><div><h4 class="font-semibold text-gray-800 mb-2">Urutkan Hasil</h4><p class="text-gray-600">Urutkan berdasarkan harga, tanggal lelang, atau lokasi.</p></div></div>
                </div>
                <div class="bg-green-50 rounded-xl p-4 border-l-4 border-green-600"><p class="text-sm text-gray-700">💡 <strong>Tips:</strong> Gunakan kombinasi beberapa filter untuk hasil pencarian yang lebih akurat!</p></div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Detail Katalog -->
    <div id="modal2" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-gradient-to-r from-green-600 to-green-700 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold">Detail Katalog</h3>
                    </div>
                    <button class="close-modal text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-green-50 rounded-xl p-4 border-l-4 border-green-600"><p class="text-gray-700"><strong class="text-green-900">Informasi Detail Properti</strong> memberikan data lengkap tentang properti yang akan dilelang.</p></div>
                <div class="bg-gray-50 rounded-lg p-4"><h4 class="font-semibold text-gray-800 mb-2">📷 Foto & Gambar Properti</h4><p class="text-gray-600">Galeri foto dari berbagai sudut, eksterior, interior, dan lingkungan sekitar.</p></div>
                <div class="bg-gray-50 rounded-lg p-4"><h4 class="font-semibold text-gray-800 mb-2">📍 Lokasi & Alamat</h4><p class="text-gray-600">Alamat lengkap, koordinat GPS, dan peta lokasi.</p></div>
                <div class="bg-gray-50 rounded-lg p-4"><h4 class="font-semibold text-gray-800 mb-2">💰 Harga Limit & Uang Jaminan</h4><p class="text-gray-600">Harga limit lelang dan besaran uang jaminan yang harus disetor.</p></div>
                <div class="bg-gray-50 rounded-lg p-4"><h4 class="font-semibold text-gray-800 mb-2">📅 Jadwal Lelang</h4><p class="text-gray-600">Tanggal pelaksanaan, batas waktu penyetoran jaminan, dan jam mulai lelang.</p></div>
                <div class="bg-gray-50 rounded-lg p-4"><h4 class="font-semibold text-gray-800 mb-2">📄 Spesifikasi Properti</h4><p class="text-gray-600">Luas tanah, luas bangunan, sertifikat (SHM/SHGB), IMB, dan kondisi properti.</p></div>
                <div class="bg-yellow-50 rounded-xl p-4 border-l-4 border-yellow-600"><p class="text-sm text-gray-700">⚠️ <strong>Penting:</strong> Selalu lakukan survey lokasi sebelum mengikuti lelang!</p></div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Ke Website Lelang -->
    <div id="modal3" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-gradient-to-r from-purple-600 to-purple-700 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold">Ke Website Lelang</h3>
                    </div>
                    <button class="close-modal text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-purple-50 rounded-xl p-4 border-l-4 border-purple-600"><p class="text-gray-700"><strong class="text-purple-900">Akses Website Resmi Lelang</strong> untuk mendaftar dan mengikuti lelang properti secara online.</p></div>
                <div class="bg-white border-2 border-purple-200 rounded-xl p-4"><div class="flex items-center gap-3 mb-2"><div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center"><span class="text-xl">🌐</span></div><div><h4 class="font-semibold text-gray-800">Website Lelang BRI</h4><a href="https://infolelang.bri.co.id/" target="_blank" class="text-purple-600 text-sm hover:underline">https://infolelang.bri.co.id/</a></div></div><p class="text-sm text-gray-600">Platform resmi lelang online Bank BRI.</p></div>
                <div class="space-y-3">
                    <h4 class="font-semibold text-gray-800">Langkah-langkah Akses:</h4>
                    <div class="flex gap-3"><div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">1</div><div class="pt-1"><p class="text-gray-700 font-medium">Klik Tombol "Ikuti Lelang"</p><p class="text-sm text-gray-600">Pada detail properti yang Anda minati.</p></div></div>
                    <div class="flex gap-3"><div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">2</div><div class="pt-1"><p class="text-gray-700 font-medium">Diarahkan ke Website Resmi</p><p class="text-sm text-gray-600">Otomatis diarahkan ke website lelang resmi (tab baru).</p></div></div>
                    <div class="flex gap-3"><div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">3</div><div class="pt-1"><p class="text-gray-700 font-medium">Registrasi & Login</p><p class="text-sm text-gray-600">Buat akun atau login jika sudah punya akun.</p></div></div>
                    <div class="flex gap-3"><div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">4</div><div class="pt-1"><p class="text-gray-700 font-medium">Upload Dokumen & Setor Jaminan</p><p class="text-sm text-gray-600">Upload KTP, NPWP, dan transfer uang jaminan.</p></div></div>
                    <div class="flex gap-3"><div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">5</div><div class="pt-1"><p class="text-gray-700 font-medium">Ikuti Lelang Online</p><p class="text-sm text-gray-600">Ajukan penawaran pada jadwal yang ditentukan.</p></div></div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4 border-l-4 border-yellow-600"><p class="text-sm text-gray-700">⚠️ <strong>Catatan:</strong> Pastikan mengakses website resmi. Jangan berikan data pribadi di website tidak resmi!</p></div>
            </div>
        </div>
    </div>

    <!-- Modal 4: Hubungi Kami -->
    <div id="modal4" class="modal-overlay hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-gradient-to-r from-orange-600 to-orange-700 text-white p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold">Hubungi Kami</h3>
                    </div>
                    <button class="close-modal text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-orange-50 rounded-xl p-4 border-l-4 border-orange-600"><p class="text-gray-700"><strong class="text-orange-900">Tim BRI Kertajaya</strong> siap membantu Anda.</p></div>
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 hover:border-orange-400 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                        <div class="flex-1"><h4 class="font-semibold text-gray-800 mb-1">Telepon</h4><p class="text-orange-600 font-medium text-lg mb-1">(031) 1234-5678</p><p class="text-sm text-gray-600">Senin - Jumat: 08.00 - 16.00 WIB</p></div>
                    </div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 hover:border-green-400 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></div>
                        <div class="flex-1"><h4 class="font-semibold text-gray-800 mb-1">WhatsApp</h4><p class="text-green-600 font-medium text-lg mb-1">+62 857-3159-9031</p><p class="text-sm text-gray-600">Chat dengan customer service kami</p></div>
                    </div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 hover:border-blue-400 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                        <div class="flex-1"><h4 class="font-semibold text-gray-800 mb-1">Email</h4><p class="text-blue-600 font-medium mb-1">lelang@brikertajaya.com</p><p class="text-sm text-gray-600">Kirim pertanyaan via email</p></div>
                    </div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 hover:border-red-400 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0"><svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                        <div class="flex-1"><h4 class="font-semibold text-gray-800 mb-1">Alamat Kantor</h4><p class="text-gray-700 mb-2">Gedung The Samator Land<br>Jl. Raya Kedung Baruk No.28 No.25<br>Sukolilo Baru, Bulak, Surabaya 60136</p><a href="https://maps.app.goo.gl/GpMAVV2BcY4vCeP8A" target="_blank" class="text-red-600 text-sm font-medium hover:underline">Lihat di Google Maps →</a></div>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 border-l-4 border-blue-600"><p class="text-sm text-gray-700">💡 <strong>Jam Operasional:</strong> Senin - Jumat: 08.00 - 16.00 WIB (kecuali hari libur nasional)</p></div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Reveal on scroll
            var reveals = document.querySelectorAll('.reveal');
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) entry.target.classList.add('active');
                });
            }, { threshold: 0.1 });
            reveals.forEach(function(el) { observer.observe(el); });

            // Search
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const searchResultsList = document.getElementById('searchResultsList');
            const faqData = [
                { question: "Apa itu katalog lelang BRI Kertajaya?", answer: "Platform informasi daftar properti yang akan dilelang oleh BRI Kertajaya." },
                { question: "Bagaimana cara mencari properti berdasarkan lokasi?", answer: "Gunakan fitur filter di halaman katalog." },
                { question: "Apakah saya bisa mengikuti lelang langsung di website ini?", answer: "Tidak, website ini hanya sebagai katalog informasi." },
                { question: "Apa itu harga limit lelang?", answer: "Harga terendah yang ditetapkan penjual untuk properti yang dilelang." },
                { question: "Bagaimana cara menghubungi BRI Kertajaya?", answer: "Melalui nomor telepon di halaman Kontak atau datang langsung ke kantor." },
                { question: "Seberapa sering katalog diupdate?", answer: "Diupdate secara berkala setiap ada jadwal lelang baru." }
            ];
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().trim();
                if (query.length > 0) {
                    const results = faqData.filter(item => item.question.toLowerCase().includes(query) || item.answer.toLowerCase().includes(query));
                    if (results.length > 0) {
                        searchResultsList.innerHTML = results.map(item => `<div class="p-3 hover:bg-gray-50 rounded-lg cursor-pointer border-b border-gray-100 last:border-0"><p class="font-semibold text-gray-800 text-sm mb-1">${item.question}</p><p class="text-xs text-gray-600">${item.answer}</p></div>`).join('');
                    } else {
                        searchResultsList.innerHTML = '<p class="text-gray-500 text-sm p-3">Tidak ada hasil ditemukan</p>';
                    }
                    searchResults.classList.remove('hidden');
                } else {
                    searchResults.classList.add('hidden');
                }
            });
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) searchResults.classList.add('hidden');
            });

            // Modal
            document.querySelectorAll('.quick-action-card').forEach(function(trigger) {
                trigger.addEventListener('click', function() {
                    const modal = document.getElementById(this.getAttribute('data-modal'));
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });
            document.querySelectorAll('.close-modal').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    this.closest('.modal-overlay').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
            });
            document.querySelectorAll('.modal-overlay').forEach(function(modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) { this.classList.add('hidden'); document.body.style.overflow = 'auto'; }
                });
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') { document.querySelectorAll('.modal-overlay').forEach(m => m.classList.add('hidden')); document.body.style.overflow = 'auto'; }
            });

            // FAQ Accordion
            document.querySelectorAll('.faq-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('.faq-icon');
                    const isOpen = !content.classList.contains('hidden');
                    document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
                    document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = 'rotate(0deg)');
                    if (!isOpen) { content.classList.remove('hidden'); icon.style.transform = 'rotate(180deg)'; }
                });
            });

            // Show All FAQ
            const showAllBtn = document.getElementById('showAllFAQBtn');
            const additionalFAQs = document.getElementById('additionalFAQs');
            const showAllIcon = document.getElementById('showAllIcon');
            let isShowingAll = false;
            showAllBtn.addEventListener('click', function() {
                isShowingAll = !isShowingAll;
                if (isShowingAll) {
                    additionalFAQs.classList.remove('hidden');
                    this.querySelector('span').textContent = 'Sembunyikan FAQ';
                    showAllIcon.style.transform = 'rotate(180deg)';
                    setTimeout(() => additionalFAQs.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
                } else {
                    additionalFAQs.classList.add('hidden');
                    this.querySelector('span').textContent = 'Lihat semua FAQ';
                    showAllIcon.style.transform = 'rotate(0deg)';
                }
            });
        });
    </script>

    <style>
        .modal-content { animation: modalSlideIn 0.3s ease-out; }
        @keyframes modalSlideIn { from { opacity: 0; transform: translateY(-20px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .quick-action-card { transition: all 0.3s ease; }
        .quick-action-card:hover { transform: translateY(-4px); }
        .modal-content::-webkit-scrollbar { width: 8px; }
        .modal-content::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .modal-content::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        .modal-content::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
@endsection