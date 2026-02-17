<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = DB::table('users')->where('role', 'admin')->first()->id;

        DB::table('system_settings')->insert([
            [
                'setting_key' => 'site_name',
                'setting value' => 'Lentera Auction',
                'setting_type' => 'string',
                'description' => 'Nama website',
                'is_public' => true,
                'updated_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}