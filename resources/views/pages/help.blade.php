@extends('layouts.app')
@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6">
                    Pusat Bantuan
                </h1>
                <p class="text-lg sm:text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Panduan lengkap menggunakan katalog lelang BRI Kertajaya
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Cari bantuan tentang katalog lelang..." 
                            class="w-full px-6 py-4 pr-12 rounded-full text-gray-800 shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all"
                        >
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 text-white p-3 rounded-full hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 text-center group cursor-pointer">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Cara Cari Katalog</h3>
                <p class="text-sm text-gray-600">Filter & pencarian katalog</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 text-center group cursor-pointer">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition-colors">
                    <svg class="w-8 h-8 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Detail Katalog</h3>
                <p class="text-sm text-gray-600">Informasi properti lelang</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 text-center group cursor-pointer">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-600 transition-colors">
                    <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Ke Website Lelang</h3>
                <p class="text-sm text-gray-600">Akses situs resmi lelang</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6 text-center group cursor-pointer">
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Categories Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Topik Bantuan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Category Card 1 -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 border border-gray-100 group cursor-pointer">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors">
                            <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">Pencarian & Filter</h3>
                            <p class="text-sm text-gray-600 mb-3">Cara mencari katalog berdasarkan lokasi, harga, dan tipe properti</p>
                            <span class="text-xs text-blue-600 font-medium">8 artikel →</span>
                        </div>
                    </div>
                </div>

                <!-- Category Card 2 -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 border border-gray-100 group cursor-pointer">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-green-600 transition-colors">
                            <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">Informasi Properti</h3>
                            <p class="text-sm text-gray-600 mb-3">Detail properti, foto, lokasi, dan harga limit lelang</p>
                            <span class="text-xs text-green-600 font-medium">12 artikel →</span>
                        </div>
                    </div>
                </div>

                <!-- Category Card 3 -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 border border-gray-100 group cursor-pointer">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-purple-600 transition-colors">
                            <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">Jadwal Lelang</h3>
                            <p class="text-sm text-gray-600 mb-3">Tanggal pelaksanaan dan cara mengikuti lelang</p>
                            <span class="text-xs text-purple-600 font-medium">6 artikel →</span>
                        </div>
                    </div>
                </div>

                <!-- Category Card 4 -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 border border-gray-100 group cursor-pointer">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-orange-600 transition-colors">
                            <svg class="w-6 h-6 text-orange-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-orange-600 transition-colors">Akses Website Resmi</h3>
                            <p class="text-sm text-gray-600 mb-3">Cara menuju ke situs lelang resmi untuk mendaftar</p>
                            <span class="text-xs text-orange-600 font-medium">5 artikel →</span>
                        </div>
                    </div>
                </div>

                <!-- Category Card 5 -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 border border-gray-100 group cursor-pointer">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-red-600 transition-colors">
                            <svg class="w-6 h-6 text-red-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-red-600 transition-colors">Lokasi BRI Kertajaya</h3>
                            <p class="text-sm text-gray-600 mb-3">Alamat kantor dan kontak BRI Kertajaya</p>
                            <span class="text-xs text-red-600 font-medium">4 artikel →</span>
                        </div>
                    </div>
                </div>

                <!-- Category Card 6 -->
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 border border-gray-100 group cursor-pointer">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-indigo-600 transition-colors">Tips & Panduan</h3>
                            <p class="text-sm text-gray-600 mb-3">Tips memilih properti dan mengikuti lelang</p>
                            <span class="text-xs text-indigo-600 font-medium">10 artikel →</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Pertanyaan yang Sering Diajukan</h2>
            
            <div class="max-w-3xl mx-auto space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <button class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">Apa itu katalog lelang BRI Kertajaya?</span>
                        <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600">
                        <p>Katalog lelang BRI Kertajaya adalah platform informasi yang menampilkan daftar properti (rumah, ruko, tanah, dll) yang akan dilelang oleh BRI Kantor Cabang Kertajaya. Website ini berfungsi sebagai media promosi dan informasi saja, untuk mengikuti lelang Anda perlu mengakses website resmi lelang.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <button class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">Bagaimana cara mencari properti berdasarkan lokasi?</span>
                        <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600">
                        <p>Gunakan fitur filter di halaman katalog. Anda bisa memilih kota/kabupaten, atau menggunakan kolom pencarian untuk mencari lokasi spesifik seperti nama kecamatan atau jalan. Filter juga tersedia untuk tipe properti dan range harga limit.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <button class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">Apakah saya bisa mengikuti lelang langsung di website ini?</span>
                        <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600">
                        <p>Tidak, website ini hanya sebagai katalog informasi. Untuk mengikuti lelang, Anda harus klik tombol "Ikuti Lelang" pada detail properti yang akan mengarahkan Anda ke website resmi lelang BRI atau platform lelang resmi seperti www.lelangbri.com.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <button class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">Apa itu harga limit lelang?</span>
                        <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600">
                        <p>Harga limit adalah harga terendah yang ditetapkan oleh penjual untuk properti yang dilelang. Penawaran dalam lelang harus dimulai dari harga limit atau lebih tinggi. Harga limit biasanya sudah memperhitungkan nilai agunan dan kondisi properti.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <button class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">Bagaimana cara menghubungi BRI Kertajaya untuk info lebih lanjut?</span>
                        <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600">
                        <p>Anda dapat menghubungi BRI Kertajaya melalui nomor telepon yang tertera di halaman Kontak Kami, atau datang langsung ke kantor BRI Cabang Kertajaya. Tim kami siap memberikan informasi detail mengenai properti dan proses lelang.</p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <button class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-800 pr-4">Seberapa sering katalog diupdate?</span>
                        <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600">
                        <p>Katalog lelang diupdate secara berkala setiap ada jadwal lelang baru atau perubahan informasi properti. Kami merekomendasikan untuk mengecek website secara rutin atau mengaktifkan notifikasi agar tidak ketinggalan informasi lelang terbaru.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    Lihat semua FAQ
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 sm:p-12 text-center text-white">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4">Butuh Informasi Lebih Detail?</h2>
            <p class="text-blue-100 mb-8 max-w-2xl mx-auto">
                Tim BRI Kertajaya siap membantu Anda dengan informasi properti lelang, jadwal, dan proses lelang. Hubungi kami untuk konsultasi gratis.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-blue-50 transition-colors shadow-lg">
                    Hubungi BRI Kertajaya
                </button>
                <button class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    Lihat Lokasi Kantor
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript for FAQ Accordion -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqButtons = document.querySelectorAll('.bg-white.rounded-xl button');
            
            faqButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('svg');
                    
                    // Close all other FAQs
                    faqButtons.forEach(otherButton => {
                        if (otherButton !== button) {
                            otherButton.nextElementSibling.classList.add('hidden');
                            otherButton.querySelector('svg').style.transform = 'rotate(0deg)';
                        }
                    });
                    
                    // Toggle current FAQ
                    content.classList.toggle('hidden');
                    
                    // Rotate icon
                    if (content.classList.contains('hidden')) {
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        icon.style.transform = 'rotate(180deg)';
                    }
                });
            });
        });
    </script>
@endsection