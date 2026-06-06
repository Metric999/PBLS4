<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Admin default jika belum ada
        Admin::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama'     => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $this->command->info('✅ Admin default dibuat → username: admin | password: admin123');
    }
}