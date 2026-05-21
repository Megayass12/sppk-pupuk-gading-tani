<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bobot;
use App\Models\Supplier;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed bobot default
        $bobots = [
            ['kode' => 'C1', 'kriteria' => 'Harga',           'tipe' => 'cost',    'bobot' => 0.30, 'keterangan' => 'Harga pupuk per kg (Rp)'],
            ['kode' => 'C2', 'kriteria' => 'Kualitas',         'tipe' => 'benefit', 'bobot' => 0.25, 'keterangan' => 'Nilai kualitas produk (skala 1-10)'],
            ['kode' => 'C3', 'kriteria' => 'Ketepatan Waktu',  'tipe' => 'benefit', 'bobot' => 0.20, 'keterangan' => 'Persentase ketepatan pengiriman (0-100)'],
            ['kode' => 'C4', 'kriteria' => 'Kapasitas',        'tipe' => 'benefit', 'bobot' => 0.15, 'keterangan' => 'Kapasitas pasokan per bulan (ton)'],
            ['kode' => 'C5', 'kriteria' => 'Jarak',            'tipe' => 'cost',    'bobot' => 0.10, 'keterangan' => 'Jarak lokasi supplier (km)'],
        ];
        foreach ($bobots as $b) {
            Bobot::create($b);
        }

        // Seed supplier contoh
        $suppliers = [
            ['kode_supplier' => 'SUP001', 'nama_supplier' => 'CV. Maju Tani',       'alamat' => 'Jember',    'telepon' => '08111111111', 'harga' => 8500,  'kualitas' => 8.5, 'ketepatan_waktu' => 90, 'kapasitas' => 50,  'jarak' => 15],
            ['kode_supplier' => 'SUP002', 'nama_supplier' => 'UD. Subur Makmur',     'alamat' => 'Banyuwangi','telepon' => '08222222222', 'harga' => 7800,  'kualitas' => 7.0, 'ketepatan_waktu' => 85, 'kapasitas' => 80,  'jarak' => 45],
            ['kode_supplier' => 'SUP003', 'nama_supplier' => 'PT. Agro Nusantara',   'alamat' => 'Malang',    'telepon' => '08333333333', 'harga' => 9200,  'kualitas' => 9.0, 'ketepatan_waktu' => 95, 'kapasitas' => 120, 'jarak' => 80],
            ['kode_supplier' => 'SUP004', 'nama_supplier' => 'CV. Hijau Lestari',    'alamat' => 'Situbondo', 'telepon' => '08444444444', 'harga' => 8100,  'kualitas' => 7.5, 'ketepatan_waktu' => 80, 'kapasitas' => 60,  'jarak' => 30],
            ['kode_supplier' => 'SUP005', 'nama_supplier' => 'UD. Sumber Rejeki',    'alamat' => 'Lumajang',  'telepon' => '08555555555', 'harga' => 7500,  'kualitas' => 6.5, 'ketepatan_waktu' => 75, 'kapasitas' => 40,  'jarak' => 25],
        ];
        foreach ($suppliers as $s) {
            Supplier::create($s);
        }
    }
}
