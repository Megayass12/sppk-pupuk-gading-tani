<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_kriteria' => 'Harga',
                'atribut' => 'cost',
                'bobot' => 0.1818,
            ],
            [
                'nama_kriteria' => 'Kualitas/sample',
                'atribut' => 'benefit',
                'bobot' => 0.2273,
            ],
            [
                'nama_kriteria' => 'Legalitas',
                'atribut' => 'benefit',
                'bobot' => 0.2045,
            ],
            [
                'nama_kriteria' => 'Pengiriman',
                'atribut' => 'benefit',
                'bobot' => 0.1818,
            ],
            [
                'nama_kriteria' => 'Respon supplier',
                'atribut' => 'benefit',
                'bobot' => 0.2045,
            ],
        ];

        foreach ($data as $item) {
            Kriteria::create($item);
        }
    }
}
