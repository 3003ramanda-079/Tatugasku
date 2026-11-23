<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class TugasKuSeeder extends Seeder
{
    public function run(): void
    {
        // Pengguna bawaan agar aplikasi langsung bisa dipakai
        Pengguna::firstOrCreate(
            ['email' => 'mahasiswa@example.com'],
            ['nama' => 'Mahasiswa']
        );

        // Contoh mata kuliah (boleh dihapus lewat menu Mata Kuliah)
        MataKuliah::firstOrCreate(['nama' => 'Pengembangan Start-Up Digital'], ['dosen' => null, 'semester' => 5]);
        MataKuliah::firstOrCreate(['nama' => 'Pemrograman Web'], ['dosen' => null, 'semester' => 5]);
    }
}
