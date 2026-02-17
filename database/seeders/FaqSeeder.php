<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = DB::table('users')->where('role', 'admin')->first()->id;

        DB::table('faqs')->insert([
            // Kategori Umum (id = 1)
            [
                'faq_category_id' => 1,
                'question' => 'Apa itu Lentera Auction?',
                'answer' => 'Lentera Auction adalah platform katalog lelang online yang menyediakan informasi lengkap mengenai properti dan kendaraan yang akan dilelang. Kami memudahkan Anda untuk menemukan aset lelang terbaik dari berbagai sumber terpercaya.',
                'display_order' => 1,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 1,
                'question' => 'Apakah saya perlu mendaftar untuk melihat katalog?',
                'answer' => 'Tidak, Anda dapat melihat semua katalog lelang tanpa perlu mendaftar atau login. Namun, untuk mengikuti lelang, Anda perlu mengakses link resmi yang tersedia di setiap katalog.',
                'display_order' => 2,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 1,
                'question' => 'Dari mana sumber katalog lelang ini?',
                'answer' => 'Katalog lelang kami bersumber dari berbagai lembaga resmi seperti bank-bank BUMN (BRI, Mandiri, BNI), KPKNL, dan instansi pemerintah lainnya yang mengadakan lelang.',
                'display_order' => 3,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Cara Pembelian (id = 2)
            [
                'faq_category_id' => 2,
                'question' => 'Bagaimana cara mengikuti lelang?',
                'answer' => 'Untuk mengikuti lelang, klik tombol "Ikuti Lelang" pada detail katalog yang akan mengarahkan Anda ke website resmi penyelenggara lelang. Pastikan Anda telah menyetor uang jaminan sebelum batas waktu yang ditentukan.',
                'display_order' => 1,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 2,
                'question' => 'Apakah saya bisa survey lokasi terlebih dahulu?',
                'answer' => 'Ya, sangat disarankan untuk melakukan survey lokasi sebelum mengikuti lelang. Informasi jadwal survey dan batas waktu biasanya tercantum pada detail katalog atau dapat dikonfirmasi melalui kontak yang tersedia.',
                'display_order' => 2,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 2,
                'question' => 'Apa yang harus disiapkan sebelum mengikuti lelang?',
                'answer' => 'Persiapan meliputi: KTP asli, NPWP, uang jaminan sesuai ketentuan, dan bukti setoran jaminan. Pastikan juga Anda sudah mempelajari detail aset dan melakukan survey lokasi.',
                'display_order' => 3,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Pembayaran (id = 3)
            [
                'faq_category_id' => 3,
                'question' => 'Berapa uang jaminan yang harus disetor?',
                'answer' => 'Besaran uang jaminan berbeda-beda untuk setiap aset dan tercantum pada detail katalog. Biasanya berkisar antara 10-20% dari nilai limit lelang.',
                'display_order' => 1,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 3,
                'question' => 'Bagaimana cara menyetor uang jaminan?',
                'answer' => 'Uang jaminan disetor sesuai instruksi pada pengumuman lelang, biasanya melalui transfer bank ke rekening penyelenggara lelang. Detail rekening dan cara pembayaran dapat dilihat di website resmi lelang.',
                'display_order' => 2,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 3,
                'question' => 'Apakah uang jaminan akan dikembalikan?',
                'answer' => 'Uang jaminan akan dikembalikan jika Anda tidak memenangkan lelang atau tidak jadi mengikuti lelang (sesuai ketentuan). Jika menang, uang jaminan akan diperhitungkan sebagai bagian dari pembayaran.',
                'display_order' => 3,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Dokumentasi (id = 4)
            [
                'faq_category_id' => 4,
                'question' => 'Dokumen apa saja yang diperlukan untuk mengikuti lelang?',
                'answer' => 'Dokumen yang diperlukan: KTP asli dan fotocopy, NPWP asli dan fotocopy, bukti setoran jaminan, dan surat kuasa (jika dikuasakan). Untuk perusahaan diperlukan dokumen tambahan seperti akta pendirian dan SIUP.',
                'display_order' => 1,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 4,
                'question' => 'Apakah sertifikat sudah tersedia saat lelang?',
                'answer' => 'Status dokumen kepemilikan (sertifikat) berbeda-beda untuk setiap aset. Informasi lengkap mengenai dokumen dapat dilihat pada detail katalog atau ditanyakan kepada penyelenggara lelang.',
                'display_order' => 2,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Lainnya (id = 5)
            [
                'faq_category_id' => 5,
                'question' => 'Bagaimana cara menghubungi customer service?',
                'answer' => 'Anda dapat menghubungi kami melalui WhatsApp, email, atau form kontak yang tersedia di website. Tim kami siap membantu Anda dari Senin-Jumat pukul 08.00-17.00 WIB.',
                'display_order' => 1,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faq_category_id' => 5,
                'question' => 'Apakah ada biaya untuk menggunakan layanan ini?',
                'answer' => 'Tidak ada biaya untuk mengakses katalog dan informasi di website kami. Semua layanan informasi katalog lelang gratis untuk publik.',
                'display_order' => 2,
                'is_active' => true,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}