<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenilaianSupplier;

class PenilaianSupplierSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // Supplier 1
            ['supplier_id' => 1, 'kriteria_id' => 1, 'nilai' => 5],
            ['supplier_id' => 1, 'kriteria_id' => 2, 'nilai' => 4],
            ['supplier_id' => 1, 'kriteria_id' => 3, 'nilai' => 5],
            ['supplier_id' => 1, 'kriteria_id' => 4, 'nilai' => 5],
            ['supplier_id' => 1, 'kriteria_id' => 5, 'nilai' => 4],

            // Supplier 2
            ['supplier_id' => 2, 'kriteria_id' => 1, 'nilai' => 4],
            ['supplier_id' => 2, 'kriteria_id' => 2, 'nilai' => 5],
            ['supplier_id' => 2, 'kriteria_id' => 3, 'nilai' => 4],
            ['supplier_id' => 2, 'kriteria_id' => 4, 'nilai' => 5],
            ['supplier_id' => 2, 'kriteria_id' => 5, 'nilai' => 5],

            // Supplier 3
            ['supplier_id' => 3, 'kriteria_id' => 1, 'nilai' => 3],
            ['supplier_id' => 3, 'kriteria_id' => 2, 'nilai' => 3],
            ['supplier_id' => 3, 'kriteria_id' => 3, 'nilai' => 3],
            ['supplier_id' => 3, 'kriteria_id' => 4, 'nilai' => 3],
            ['supplier_id' => 3, 'kriteria_id' => 5, 'nilai' => 3],

            // Supplier 4
            ['supplier_id' => 4, 'kriteria_id' => 1, 'nilai' => 5],
            ['supplier_id' => 4, 'kriteria_id' => 2, 'nilai' => 5],
            ['supplier_id' => 4, 'kriteria_id' => 3, 'nilai' => 4],
            ['supplier_id' => 4, 'kriteria_id' => 4, 'nilai' => 4],
            ['supplier_id' => 4, 'kriteria_id' => 5, 'nilai' => 5],

            // Supplier 5
            ['supplier_id' => 5, 'kriteria_id' => 1, 'nilai' => 2],
            ['supplier_id' => 5, 'kriteria_id' => 2, 'nilai' => 4],
            ['supplier_id' => 5, 'kriteria_id' => 3, 'nilai' => 2],
            ['supplier_id' => 5, 'kriteria_id' => 4, 'nilai' => 3],
            ['supplier_id' => 5, 'kriteria_id' => 5, 'nilai' => 3],

        ];

        foreach ($data as $item) {
            PenilaianSupplier::create($item);
        }
    }
}
