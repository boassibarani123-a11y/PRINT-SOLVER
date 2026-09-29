<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default admin
        User::updateOrCreate(
            ['email' => 'admin@printsolver.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );

        // Default prices & business info
        $defaults = [
            'price_color'   => '1000',
            'price_bw'      => '500',
            'price_booklet' => '800',
            'business_name' => 'PRINT SOLVER',
            'business_tagline' => 'Solusi Cetak Cepat & Berkualitas',
            'business_phone' => '0812-3456-7890',
            'business_address' => 'Jl. Contoh No. 123, Kota Anda',
        ];

        foreach ($defaults as $k => $v) {
            Setting::updateOrCreate(['key' => $k], ['value' => $v]);
        }
    }
}
