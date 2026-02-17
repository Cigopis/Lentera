<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Employee::updateOrCreate(
            ['email' => 'admin@lentera.test'],
            [
                'name' => 'Admin Lentera',
                'username' => 'admin',
                'full_name' => 'Administrator Lentera',
                'email_verified_at' => now(),
                'password' => Hash::make('adminselaluizin26'),
                'is_active' => true,
            ]
        );

        $superAdmin->assignRole('super admin');


        $admin = Employee::updateOrCreate(
            ['email' => 'marketing@lentera.test'],
            [
                'name' => 'Staff Marketing',
                'username' => 'marketing01',
                'full_name' => 'Staff Marketing Lentera',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $admin->assignRole('admin');


        $staff = Employee::updateOrCreate(
            ['email' => 'shafa@lentera.staff'],
            [
                'name' => 'Shafa',
                'username' => 'shafa',
                'full_name' => 'Staff Lelang',
                'email_verified_at' => now(),
                'password' => Hash::make('shafa123'),
                'is_active' => true,
            ]
        );

        $staff->assignRole('staff');
    }
}
