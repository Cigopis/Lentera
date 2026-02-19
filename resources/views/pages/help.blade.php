@extends('layouts.app')
@section('content')

<style>
html, body { background-color: #f0f9ff !important; }

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
    min-height: 52vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 80px 24px 120px;
}
.help-hero-bg {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 30% 30%, #bfdbfe 0%, transparent 55%),
        radial-gradient(ellipse at 70% 70%, #ddd6fe 0%, transparent 55%),
        linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
    z-index: 0;
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

/* ---- Quick Actions ---- */
.quick-actions {
    position: relative;
    z-index: 20;
    max-width: 1200px;
    margin: -48px auto 0;
    padding: 0 24px;
}
.quick-card {
    background: white;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 28px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}
.quick-card:hover {
    border-color: #bfdbfe;
    box-shadow: 0 16px 40px rgba(59,130,246,0.12);
    transform: translateY(-4px);
}
.quick-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    transition: all 0.3s ease;
}
.quick-card:hover .quick-icon { transform: scale(1.1); }
.quick-card h3 {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 4px;
}
.quick-card p {
    font-size: 12px;
    color: #94a3b8;
}

/* ---- Section title ---- */
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

/* ---- Topic Cards ---- */
.topic-card {
    background: white;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.topic-card:hover {
    border-color: #bfdbfe;
    box-shadow: 0 12px 32px rgba(59,130,246,0.1);
    transform: translateY(-3px);
}
.topic-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.topic-card:hover .topic-icon { transform: scale(1.05); }
.topic-card h3 {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
    transition: color 0.2s;
}
.topic-card p {
    font-size: 12px;
    color: #94a3b8;
    margin-bottom: 10px;
    line-height: 1.6;
}
.topic-count {
    font-size: 11px;
    font-weight: 600;
}

/* ---- FAQ ---- */
.faq-item {
    background: white;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.faq-item.open {
    border-color: #bfdbfe;
    box-shadow: 0 8px 24px rgba(59,130,246,0.08);
}
.faq-btn {
    width: 100%;
    padding: 20px 24px;
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: none;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}
.faq-btn:hover { background: #f8fafc; }
.faq-btn span {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    padding-right: 16px;
    line-height: 1.4;
}
.faq-icon {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.faq-item.open .faq-icon {
    background: #dbeafe;
    transform: rotate(180deg);
}
.faq-icon svg { width: 14px; height: 14px; stroke: #64748b; }
.faq-item.open .faq-icon svg { stroke: #3b82f6; }
.faq-body {
    display: none;
    padding: 0 24px 20px;
    font-size: 13px;
    color: #64748b;
    line-height: 1.75;
    border-top: 1px solid #f1f5f9;
    padding-top: 16px;
}
.faq-body.open { display: block; }

/* ---- CTA ---- */
.help-cta {
    background:
        radial-gradient(ellipse at 20% 50%, #bfdbfe 0%, transparent 60%),
        radial-gradient(ellipse at 80% 50%, #ddd6fe 0%, transparent 60%),
        linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%);
    border: 1.5px solid #e2e8f0;
    border-radius: 28px;
    padding: 60px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.help-cta h2 {
    font-size: clamp(22px, 3.5vw, 32px);
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 12px;
}
.help-cta p {
    color: #64748b;
    font-size: 15px;
    max-width: 480px;
    margin: 0 auto 32px;
    line-height: 1.7;
}
.cta-btn-primary {
    display: inline-block;
    padding: 14px 32px;
    border-radius: 99px;
    background: #3b82f6;
    color: white;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(59,130,246,0.3);
}
.cta-btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(59,130,246,0.4);
}
.cta-btn-secondary {
    display: inline-block;
    padding: 14px 32px;
    border-radius: 99px;
    background: white;
    color: #3b82f6;
    font-size: 14px;
    font-weight: 600;
    border: 1.5px solid #bfdbfe;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}
.cta-btn-secondary:hover {
    border-color: #3b82f6;
    box-shadow: 0 8px 20px rgba(59,130,246,0.1);
    transform: translateY(-2px);
}
</style>


{{-- ===================== HERO ==================== --}}
<div class="help-hero">
    <div class="help-hero-bg"></div>
    <div class="help-hero-rays"></div>

    <div class="help-hero-content">
        <p class="section-eyebrow" style="margin-bottom:12px;">Support Center</p>
        <h1>Pusat Bantuan</h1>
        <p>Panduan lengkap menggunakan katalog lelang Lentera Kertajaya</p>

        <div class="help-search">
            <input type="text" placeholder="Cari bantuan tentang katalog lelang...">
            <button>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </div>
    </div>
</div>


{{-- ===================== QUICK ACTIONS ==================== --}}
<div class="quick-actions">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="quick-card reveal">
            <div class="quick-icon bg-blue-50">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3>Cara Cari Katalog</h3>
            <p>Filter &amp; pencarian katalog</p>
        </div>

        <div class="quick-card reveal">
            <div class="quick-icon bg-emerald-50">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3>Detail Katalog</h3>
            <p>Informasi properti lelang</p>
        </div>

        <div class="quick-card reveal">
            <div class="quick-icon bg-violet-50">
                <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </div>
            <h3>Ke Website Lelang</h3>
            <p>Akses situs resmi lelang</p>
        </div>

        <div class="quick-card reveal">
            <div class="quick-icon bg-orange-50">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3>Hubungi Kami</h3>
            <p>Info lebih lanjut</p>
        </div>

    </div>
</div>


{{-- ===================== TOPIK BANTUAN ==================== --}}
<div class="max-w-7xl mx-auto px-6 py-24">

    <div class="text-center reveal">
        <span class="section-eyebrow">Kategori</span>
        <h2 class="section-heading">Topik Bantuan</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        <div class="topic-card reveal">
            <div class="flex items-start gap-4">
                <div class="topic-icon bg-blue-50">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div>
                    <h3>Pencarian &amp; Filter</h3>
                    <p>Cara mencari katalog berdasarkan lokasi, harga, dan tipe properti</p>
                    <span class="topic-count text-blue-500">8 artikel →</span>
                </div>
            </div>
        </div>

        <div class="topic-card reveal">
            <div class="flex items-start gap-4">
                <div class="topic-icon bg-emerald-50">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h3>Informasi Properti</h3>
                    <p>Detail properti, foto, lokasi, dan harga limit lelang</p>
                    <span class="topic-count text-emerald-500">12 artikel →</span>
                </div>
            </div>
        </div>

        <div class="topic-card reveal">
            <div class="flex items-start gap-4">
                <div class="topic-icon bg-violet-50">
                    <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3>Jadwal Lelang</h3>
                    <p>Tanggal pelaksanaan dan cara mengikuti lelang</p>
                    <span class="topic-count text-violet-500">6 artikel →</span>
                </div>
            </div>
        </div>

        <div class="topic-card reveal">
            <div class="flex items-start gap-4">
                <div class="topic-icon bg-orange-50">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <div>
                    <h3>Akses Website Resmi</h3>
                    <p>Cara menuju ke situs lelang resmi untuk mendaftar</p>
                    <span class="topic-count text-orange-500">5 artikel →</span>
                </div>
            </div>
        </div>

        <div class="topic-card reveal">
            <div class="flex items-start gap-4">
                <div class="topic-icon bg-red-50">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3>Lokasi BRI Kertajaya</h3>
                    <p>Alamat kantor dan kontak BRI Kertajaya</p>
                    <span class="topic-count text-red-400">4 artikel →</span>
                </div>
            </div>
        </div>

        <div class="topic-card reveal">
            <div class="flex items-start gap-4">
                <div class="topic-icon bg-indigo-50">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                <div>
                    <h3>Tips &amp; Panduan</h3>
                    <p>Tips memilih properti dan mengikuti lelang</p>
                    <span class="topic-count text-indigo-500">10 artikel →</span>
                </div>
            </div>
        </div>

    </div>
</div>


{{-- ===================== FAQ ==================== --}}
<div class="max-w-3xl mx-auto px-6 pb-24">

    <div class="text-center reveal">
        <span class="section-eyebrow">FAQ</span>
        <h2 class="section-heading">Pertanyaan yang Sering Diajukan</h2>
    </div>

    <div class="space-y-3">

        <div class="faq-item reveal">
            <button class="faq-btn">
                <span>Apa itu katalog lelang BRI Kertajaya?</span>
                <div class="faq-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div class="faq-body">
                Katalog lelang BRI Kertajaya adalah platform informasi yang menampilkan daftar properti (rumah, ruko, tanah, dll) yang akan dilelang oleh BRI Kantor Cabang Kertajaya. Website ini berfungsi sebagai media promosi dan informasi saja, untuk mengikuti lelang Anda perlu mengakses website resmi lelang.
            </div>
        </div>

        <div class="faq-item reveal">
            <button class="faq-btn">
                <span>Bagaimana cara mencari properti berdasarkan lokasi?</span>
                <div class="faq-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div class="faq-body">
                Gunakan fitur filter di halaman katalog. Anda bisa memilih kota/kabupaten, atau menggunakan kolom pencarian untuk mencari lokasi spesifik seperti nama kecamatan atau jalan. Filter juga tersedia untuk tipe properti dan range harga limit.
            </div>
        </div>

        <div class="faq-item reveal">
            <button class="faq-btn">
                <span>Apakah saya bisa mengikuti lelang langsung di website ini?</span>
                <div class="faq-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div class="faq-body">
                Tidak, website ini hanya sebagai katalog informasi. Untuk mengikuti lelang, Anda harus klik tombol "Ikuti Lelang" pada detail properti yang akan mengarahkan Anda ke website resmi lelang BRI atau platform lelang resmi seperti www.lelangbri.com.
            </div>
        </div>

        <div class="faq-item reveal">
            <button class="faq-btn">
                <span>Apa itu harga limit lelang?</span>
                <div class="faq-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div class="faq-body">
                Harga limit adalah harga terendah yang ditetapkan oleh penjual untuk properti yang dilelang. Penawaran dalam lelang harus dimulai dari harga limit atau lebih tinggi. Harga limit biasanya sudah memperhitungkan nilai agunan dan kondisi properti.
            </div>
        </div>

        <div class="faq-item reveal">
            <button class="faq-btn">
                <span>Bagaimana cara menghubungi BRI Kertajaya untuk info lebih lanjut?</span>
                <div class="faq-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div class="faq-body">
                Anda dapat menghubungi BRI Kertajaya melalui nomor telepon yang tertera di halaman Kontak Kami, atau datang langsung ke kantor BRI Cabang Kertajaya. Tim kami siap memberikan informasi detail mengenai properti dan proses lelang.
            </div>
        </div>

        <div class="faq-item reveal">
            <button class="faq-btn">
                <span>Seberapa sering katalog diupdate?</span>
                <div class="faq-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </button>
            <div class="faq-body">
                Katalog lelang diupdate secara berkala setiap ada jadwal lelang baru atau perubahan informasi properti. Kami merekomendasikan untuk mengecek website secara rutin agar tidak ketinggalan informasi lelang terbaru.
            </div>
        </div>

    </div>

    <div class="text-center mt-10 reveal">
        <a href="#" class="inline-flex items-center gap-2 text-blue-500 font-semibold text-sm hover:text-blue-700 transition">
            Lihat semua FAQ
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

</div>


{{-- ===================== CTA ==================== --}}
<div class="max-w-5xl mx-auto px-6 pb-28">
    <div class="help-cta reveal">
        <p class="section-eyebrow" style="margin-bottom:12px;">Kontak</p>
        <h2>Butuh Informasi Lebih Detail?</h2>
        <p>Tim Lentera Kertajaya siap membantu Anda dengan informasi properti lelang, jadwal, dan proses lelang. Hubungi kami untuk konsultasi gratis.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button class="cta-btn-primary">Hubungi BRI Kertajaya</button>
            <button class="cta-btn-secondary">Lihat Lokasi Kantor</button>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ===== Scroll Reveal ===== */
    var reveals = document.querySelectorAll('.reveal');
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(function(el) { observer.observe(el); });

    /* ===== FAQ Accordion ===== */
    var faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(function(item) {
        var btn  = item.querySelector('.faq-btn');
        var body = item.querySelector('.faq-body');

        btn.addEventListener('click', function() {
            var isOpen = item.classList.contains('open');

            /* Close all */
            faqItems.forEach(function(i) {
                i.classList.remove('open');
                i.querySelector('.faq-body').classList.remove('open');
            });

            /* Toggle clicked */
            if (!isOpen) {
                item.classList.add('open');
                body.classList.add('open');
            }
        });
    });

});
</script>

@endsection