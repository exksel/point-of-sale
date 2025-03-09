<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat akun admin default.
     */
    public function run(): void
    {
        // Cek apakah akun admin sudah ada, default login akun
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'full_name' => '',
                'phone_number' => '',
                'username' => 'admin',
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
