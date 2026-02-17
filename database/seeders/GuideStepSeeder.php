<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuideStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = DB::table('users')->where('role', 'admin')->first()->id;

        DB::table('guide_steps')->insert([
            [
                'step_number' => 1,
                'title' => 'Cari Properti atau Aset',
                'description' => 'Telusuri katalog lelang kami untuk menemukan properti atau kendaraan yang sesuai dengan kebutuhan Anda. Gunakan fitur pencarian dan filter untuk mempermudah pencarian.',
                'icon' => 'search',
                'is_active' => true,
                'display_order' => 1,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'step_number' => 2,
                'title' => 'Pelajari Detail Aset',
                'description' => 'Baca informasi lengkap mengenai aset yang diminati, termasuk spesifikasi, lokasi, harga limit, dan jadwal lelang. Download brosur untuk informasi lebih detail.',
                'icon' => 'file-text',
                'is_active' => true,
                'display_order' => 2,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'step_number' => 3,
                'title' => 'Lakukan Survey Lokasi',
                'description' => 'Kunjungi lokasi aset untuk memastikan kondisi sesuai dengan deskripsi. Pastikan Anda melakukan survey sebelum batas waktu yang ditentukan.',
                'icon' => 'map-pin',
                'is_active' => true,
                'display_order' => 3,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'step_number' => 4,
                'title' => 'Setor Uang Jaminan',
                'description' => 'Setor uang jaminan sesuai jumlah yang tertera sebelum batas waktu penyetoran. Simpan bukti setoran dengan baik untuk keperluan verifikasi.',
                'icon' => 'credit-card',
                'is_active' => true,
                'display_order' => 4,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'step_number' => 5,
                'title' => 'Ikuti Lelang',
                'description' => 'Ikuti lelang pada tanggal dan waktu yang telah ditentukan. Anda dapat mengikuti lelang secara online melalui link yang tersedia atau datang langsung ke lokasi lelang.',
                'icon' => 'calendar',
                'is_active' => true,
                'display_order' => 5,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'step_number' => 6,
                'title' => 'Bayar dan Selesaikan Administrasi',
                'description' => 'Jika Anda memenangkan lelang, segera lakukan pembayaran penuh dan lengkapi dokumen administrasi sesuai ketentuan yang berlaku.',
                'icon' => 'check-circle',
                'is_active' => true,
                'display_order' => 6,
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}