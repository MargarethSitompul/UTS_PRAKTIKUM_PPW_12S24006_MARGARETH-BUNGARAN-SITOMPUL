<?php

namespace Database\Seeders;

use App\Models\categoris;
use App\Models\Aset;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\loan_request;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 Kategori tetap sesuai domain perpustakaan
        $kategoris = [
            ['kode_kategori' => 'KAT01', 'nama_kategori' => 'Server & Cloud'],
            ['kode_kategori' => 'KAT02', 'nama_kategori' => 'Internet of Things'],
            ['kode_kategori' => 'KAT03', 'nama_kategori' => 'Multimedia & Drone'],
        ];

        foreach ($kategoris as $kat) {
            Kategori::create($kat);
        }

        // Buat 20 Aset menggunakan Factory
        Aset::factory(20)->create();
                User::create([                        // akun admin untuk uji
            'name'     => 'Admin Del',
            'email'    => 'admin@del.ac.id', // sesuai modul
            'password' => 'password123',      // otomatis di-hash oleh cast 'hashed' di model User
        ]);

        $kategori = Kategori::first();        // ambil satu kategori untuk sampel aset

        Aset::create([                        // sampel aset stok 0, untuk demo penolakan
            'kode_Aset Inventaris ' => '001', 'Nama_ Perangkat' => 'Raspberry Pi 4 Model B (8GB RAM) Starter Kit', 'Spesifikasi Teknis' => 'Quad-core Cortex-A72 @1.5GHz, 8GB LPDDR4, MicroSD 64GB Class 10, Casing 
Alumunium Aktif Fan, Power Supply Type-C Resmi',
            'Kondisi Fisik' => 'Baik ', 'Tarif Kompensasi Harian' => 15000 ,
            'categori_id' => $categori->id, 'stok' => 0, 'sinopsis' => 'Untuk menguji stok habis.',
        ]);

    }
}