<?php

namespace App\Imports;

use App\Models\Kriteria;
use App\Models\PenilaianSupplier;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SupplierImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function collection(Collection $rows)
    {
        $kriteriaHeadings = Kriteria::orderBy('id')
            ->get()
            ->mapWithKeys(fn($item) => ['Kriteria: ' . $item->nama_kriteria => $item->id])
            ->toArray();

        foreach ($rows as $row) {
            if (empty($row['kode'])) {
                continue;
            }

            $supplier = Supplier::updateOrCreate(
                ['kode' => $row['kode']],
                [
                    'nama_supplier' => $row['nama_supplier'] ?? '',
                    'alamat' => $row['alamat'] ?? '',
                    'no_telp' => $row['no_telp'] ?? '',
                    'email' => $row['email'] ?? '',
                ]
            );

            foreach ($kriteriaHeadings as $heading => $kriteriaId) {
                if (!isset($row[$heading])) {
                    continue;
                }

                PenilaianSupplier::updateOrCreate(
                    ['supplier_id' => $supplier->id, 'kriteria_id' => $kriteriaId],
                    ['nilai' => (float) $row[$heading]]
                );
            }
        }
    }
}
