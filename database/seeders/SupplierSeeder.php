<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode' => 'S001',
                'nama_supplier' => 'PT Maju Jaya',
                'alamat' => 'Surabaya',
                'no_telp' => '081234567001',
                'email' => 'majujaya@gmail.com',
            ],
            [
                'kode' => 'S002',
                'nama_supplier' => 'CV Berkah Abadi',
                'alamat' => 'Malang',
                'no_telp' => '081234567002',
                'email' => 'berkahabadi@gmail.com',
            ],
            [
                'kode' => 'S003',
                'nama_supplier' => 'PT Sumber Rejeki',
                'alamat' => 'Sidoarjo',
                'no_telp' => '081234567003',
                'email' => 'sumberrejeki@gmail.com',
            ],
            [
                'kode' => 'S004',
                'nama_supplier' => 'CV Nusantara',
                'alamat' => 'Pasuruan',
                'no_telp' => '081234567004',
                'email' => 'nusantara@gmail.com',
            ],
            [
                'kode' => 'S005',
                'nama_supplier' => 'PT Global Supplier',
                'alamat' => 'Mojokerto',
                'no_telp' => '081234567005',
                'email' => 'globalsupplier@gmail.com',
            ],
        ];

        foreach ($data as $item) {
            Supplier::create($item);
        }
    }
}
