<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = DB::table('users')-> where('role', 'admin')-> first()->id;
        
        DB::table('banners')->insert([
            [
             'title' => 'Lelang Properti Impian Anda',
                'subtitle' => 'Dapatkan properti terbaik dengan harga terjangkau',
                'description' => 'Temukan berbagai pilihan rumah, tanah, dan kendaraan dari sumber terpercaya',
                'image_path' => 'banners/banner-1.jpg',
                'mobile_image_path' => 'banners/banner-1-mobile.jpg',
                'link_url' => '/katalog',
                'link_type' => 'internal',
                'button_text' => 'Lihat Katalog',
                'position' => 'main_slider',
                'display_order' => 1,
                'is_active' => true,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => now()->addMonths(3)->format('Y-m-d'),
                'created_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
